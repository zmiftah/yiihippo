<?php

class MediaController extends AbBackController
{
	const MEDIA_LIMIT = 10;
  const UPLOAD_DIR  = '/content/upload/media';

  private $_sizeAdminList   = 32;
  private $_sizeFrontWidget = 36; //featured
  private $_sizeFrontList   = array(175,140); //featured

  public function init()
  {
    $this->attachBehavior('media', new AbMediaBehavior());
    parent::init();
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . ' - Pustaka Media';

    $criteria = new CDbCriteria(array(
      'select'=>'*',
      'condition'=>'type='.LinkModel::LINK_TYPE_MEDIA,
      'order'=>'link_id DESC'
    ));

    $page = 'LinkModel_page';
    $view = $this->generateData('LinkModel', $_GET[$page], self::MEDIA_LIMIT, $criteria);
    $this->render('list', $view);
  }

  public function actionUpload()
  {
  	$this->pageTitle = Yii::app()->name . ' - Upload New Media';
    $model = new LinkModel;

    if ( isset($_POST['submit']) ) {
      $filename = $this->getFileName($_POST['filename'], $_POST['fileext']);
      $img = CUploadedFile::getInstanceByName("fileupload");

      if (in_array($img->type, array(
        'image/gif', 'image/jpeg', 'image/pjpeg', 
        'image/png', 'image/svg+xml', 'image/tiff'
      ))) {
        $model->name         = $filename;
        $model->content_type = $img->type;
        $imgsize             = getimagesize($img->tempName);
        $model->width        = $imgsize[0];
        $model->type         = LinkModel::LINK_TYPE_MEDIA;
        $model->created      = new CDbExpression('NOW()');
        $model->desc         = serialize($imgsize);

        if( $model->save() ) {
          $id         = PseudoCrypt::hash($model->link_id);
          $resultFile = $this->getUploadPath($id).'/'.$filename;
          $saved      = $img->saveAs($resultFile);

          try {
            $this->createThumbnail($resultFile, $this->_sizeAdminList, $this->_sizeAdminList);
            $this->createThumbnail($resultFile, $this->_sizeFrontWidget, $this->_sizeFrontWidget);
            $this->createThumbnail($resultFile, $this->_sizeFrontList[0], $this->_sizeFrontList[1]);
          } catch (Exception $e) {}

          $model->url = self::UPLOAD_DIR."/$id/$filename";
          $model->save();

          if ( isset($_POST['checkThumb']) && $saved ) {
            $thumbFile = $this->createThumbnail($resultFile, $_POST['dwidth'], $_POST['dheight']);
          }

          Yii::app()->user->setFlash('success', "'$filename' berhasil ditambahkan");
          $this->redirectUrl('media/index');
        } else {
          Yii::app()->user->setFlash('error', "'$filename' gagal ditambahkan");
        }
      } else {
        Yii::app()->user->setFlash('error', "'$filename' bukan file gambar");
      }
    }
  	
  	$this->render('form');
  }

  public function actionDetail() 
  {
    $id = $_GET['id'];
    $row = LinkModel::model()->findByPk($id);

    if ( !($row instanceof LinkModel) ) {
      Yii::app()->user->setFlash('error', "Media yang Anda cari tidak ditemukan");
      $this->redirectUrl('media/index');
    }
    
    $this->render('detail', array(
      'row'=>$row
    ));
  }

  public function actionThumbs()
  {
    $id = $_GET['id'];
    $row = LinkModel::model()->findByPk($id);

    $condition = $row instanceof LinkModel && $row->isImage;
    if ( !$condition ) {
      Yii::app()->user->setFlash('error', "Media yang Anda cari tidak ditemukan");
      $this->redirectUrl('media/index');
    }

    if ( isset($_POST['submit']) ) {
      $resultFile   = $this->uploadPath.'/'.$row->name;
      $thumbFileDef = $this->createThumbnail($resultFile, $_POST['dwidth'], $_POST['dheight']);

      if ($thumbFileDef) {
        Yii::app()->user->setFlash('success', "Berhasil membuat thumbnail");
        $this->redirectUrl('media/index');
      } else {
        Yii::app()->user->setFlash('error', "Terdapat kesalahan di server kami, silakan coba lagi");
      }
    }

    $this->render('thumbs', array(
      'row'=>$row
    ));
  }

  public function actionDelete()
  {
    $id   = $_GET['id'];
    $row  = LinkModel::model()->findByPk($id);

    if ( !($row instanceof LinkModel) ) {
      Yii::app()->user->setFlash('error', "Media yang Anda cari tidak ditemukan");
      $this->redirectUrl('media/index');
    }

    $path = dirname(dirname(Yii::app()->basePath));
    $id   = PseudoCrypt::hash($row->link_id);
    $name = $row->name;
    $url  = $row->url;
    $stat = 'error'; $opr  = 'gagal';

    if ( $row->delete() ) {
      $folder = $path.self::UPLOAD_DIR."/$id";

      $dir = new DirectoryIterator($folder);
      foreach ($dir as $file) {
        if($file->isFile()) {
          $filename = $folder.'/'.$file->getFilename();
          @unlink($filename);
        }
      }

      if( @rmdir($folder) ){
        $status = 'success';
        $opr    = 'berhasil';
      }

      Yii::app()->user->setFlash($status, "'$name' $opr dihapus");
      $this->redirectUrl('media/index');
    }
  }

  public function actionImageList()
  {
    $this->layout = '//layouts/blank';
    
    $images = LinkModel::model()->featured()->images()->findAll();
    $this->render('featured', array(
      'images'=>$images,
      'type'=>'list'
    ));
  }

  public function actionGetImage()
  {
    $this->layout = '//layouts/blank';

    $id = $_POST['id'];
    $image = LinkModel::model()->findByPk($id);

    if ( $image instanceof LinkModel ) {
      header('Content-Type: application/json');
      echo CJSON::encode($image);
    }
  }

  /* CKEditor File Browser */
  public function actionBrowse()
  {
    $this->layout = '//layouts/blank';
    
    $images = LinkModel::model()->featured()->images()->findAll();
    $this->render('browse', array(
      'images'=>$images,
      'type'=>'list'
    ));
  }

  public function actionFileUpload()
  {
    $imageType = array(
      'image/gif', 'image/jpeg', 'image/pjpeg', 
      'image/png', 'image/svg+xml', 'image/tiff'
    );

    $img = CUploadedFile::getInstanceByName("upload");

    if ( $img instanceof CUploadedFile ) {
      if (in_array($img->type, $imageType)) {
        $filename            = $img->name;

        $model               = new LinkModel;
        $model->name         = $filename;
        $model->content_type = $img->type;
        $imgsize             = getimagesize($img->tempName);
        $model->width        = $imgsize[0];
        $model->type         = LinkModel::LINK_TYPE_MEDIA;
        $model->created      = new CDbExpression('NOW()');
        $model->desc         = serialize($imgsize);

        if( $model->save() ) {
          $id         = PseudoCrypt::hash($model->link_id);
          $resultFile = $this->getUploadPath($id).'/'.$filename;
          $saved      = $img->saveAs($resultFile);

          try {
            $this->createThumbnail($resultFile, $this->_sizeAdminList, $this->_sizeAdminList);
            $this->createThumbnail($resultFile, $this->_sizeFrontWidget, $this->_sizeFrontWidget);
            $this->createThumbnail($resultFile, $this->_sizeFrontList[0], $this->_sizeFrontList[1]);
          } catch (Exception $e) {}

          $model->url = self::UPLOAD_DIR."/$id/$filename";
          if($model->save()){
            ?><script>alert('Gambar berhasil di upload.'); </script><?php  
          } else {
            ?><script>alert('Gambar gagal di upload.'); </script><?php  
          }
        } else {
          ?><script>alert('Bukan File Gambar.'); </script><?php
        }
      } else {
        ?><script>alert('File bermasalah.'); </script><?php
      }
    }
  }
}
