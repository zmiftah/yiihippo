<?php

class BannerController extends AbBackController 
{
	const UPLOAD_DIR  = '/content/upload/banner';
	const BANNER_LIMIT = 10;

	public function init()
  {
    $this->attachBehavior('media', new AbMediaBehavior());
    parent::init();
  }

	public function actionIndex() 
	{
		$this->pageTitle   = Yii::app()->name . ' - Daftar Banner';

		$criteria = new CDbCriteria(array(
			'select'=>'*',
			'condition'=>'type='.LinkModel::LINK_TYPE_BANNER,
			'order'=>'link_id DESC, target'
		));

		$page = 'LinkModel_page';
    $view = $this->generateData('LinkModel', $_GET[$page], self::BANNER_LIMIT, $criteria);
    $this->render('list', $view);
	}

	public function actionAdd() 
	{
		$this->pageTitle = Yii::app()->name . ' - Tambah Banner';
		$model = new LinkModel;
		
		if ( isset( $_POST['LinkModel'] ) ) {
			$model->type      = LinkModel::LINK_TYPE_BANNER;
			$model->desc      = serialize(array(
				'text'=>$_POST['text'],
				'width'=>$_POST['width'],
				'height'=>$_POST['height']
			));
			$model->target    = $_POST['position'];
			$image_url = 'http://'.str_replace('http://', '', $_POST['LinkModel']['image_url']);
			$model->image_url = $image_url;
			$model->created   = new CDbExpression('NOW()');

			$banner = CUploadedFile::getInstance($model, 'url');
			if ( $banner ) {
				$pinfo = pathinfo($banner->name);
				$filename = $this->getFileName($_POST['filename'], $pinfo['extension']);
				$destination = dirname(dirname(Yii::app()->basePath)) . self::UPLOAD_DIR . "/$filename";
				$filepath = self::UPLOAD_DIR . "/$filename";

				$model->name = $filename;
				$model->content_type = $banner->type;
				$model->url = $filepath;
				$imgsize = getimagesize($banner->tempName);
				$model->width = $imgsize[0];

				if ( $model->save() ) {
					$banner->saveAs( $destination );

					try {
						$width  = $this->getWidth($_POST['position']); 
						$dim    = $this->getDimensions($destination, $banner->type); 
						if (is_array($dim)) {
							$new_width  = (int)$dim['w'];
							$new_height = (int)$dim['h']; 
							$height = ($new_height * $width) / $new_width;

							if ($width>50 && $height>50) {
								$this->createThumbnail($destination, $width, ceil($height), false);
							}
						}
					} catch (Exception $e) {}

					Yii::app()->user->setFlash( 'success', "Banner '$filename' berhasil ditambahkan" );

					$this->redirect('index.php');
				}
			} else {
				Yii::app()->user->setFlash( 'error', "Banner belum dipilih" );
			}
		}
		
		$position = LinkModel::getListPosition();
		$this->render('form', array(
			'model' => $model,
			'title' => 'Tambah',
			'positionList' => $position,
		));
	}

	public function actionEdit() 
	{
		$id = $_GET['id'];
		$this->pageTitle = Yii::app()->name . ' - Edit Banner';

		$model = LinkModel::model()->findByPk( $id );
		if ( !( $model instanceof LinkModel ) ) {
			Yii::app()->user->setFlash( 'error', "<strong>Error</strong> Banner yang Anda cari tidak ditemukan" );
			$this->redirect( 'index.php' );
		}

		if ( isset($_POST['LinkModel']) ) {
			$banner = CUploadedFile::getInstance($model, 'url');
			if ( $banner ) {
				$pinfo = pathinfo($banner->name);
				$filename = $this->getFileName($_POST['filename'], $pinfo['extension']);
				$destination = dirname(dirname(Yii::app()->basePath)).self::UPLOAD_DIR."/$filename";
				$filepath = self::UPLOAD_DIR . "/$filename";
			} else {
				$pinfo = pathinfo($model->url);
				$filename = $this->getFileName($_POST['filename'], $pinfo['extension']);
			}

			$old_name    = $model->name;
			$model->name = $filename; 
			$model->desc = serialize(array(
				'text' => $_POST['text'],
				'width'=>$_POST['width'],
				'height'=>$_POST['height'],
				'modified' => date('Y-m-d H:i:s')
			));
			$model->target    = $_POST['position'];
			$image_url = 'http://'.str_replace('http://', '', $_POST['LinkModel']['image_url']);
			$model->image_url = $image_url;

			if ($banner) {
				$old_url    = $model->url;
				$model->url = $filepath;
				$model->content_type = $banner->type;
				$imgsize = getimagesize($banner->tempName);
				$model->width = $imgsize[0];
			}

			if ($old_name != $model->name) {
				$dirpath = dirname(dirname(Yii::app()->basePath)).self::UPLOAD_DIR.'/';
				@rename($dirpath.$old_name, $dirpath.$model->name);
				$model->url = self::UPLOAD_DIR . "/$model->name";
			}

			if ( $model->save() ) {
				if ( $banner ) {
					$banner->saveAs($destination);

					if ($old_url != $model->url) {
						$oldfile = dirname(dirname(Yii::app()->basePath)).$old_url;
						@unlink($oldfile);
					}
				}
				Yii::app()->user->setFlash('success', "Banner '$filename' berhasil ditambahkan");

				$this->redirect('index.php');
			}
		}

		$text = $this->getText($model->desc);
		$positionList = LinkModel::getListPosition();
		$this->render('form', array(
			'model' => $model,
			'title' => 'Edit',
			'position' => $model->target,
			'positionList' => $positionList,
			'text' => $text,
		));
	}

	public function actionDelete() 
	{
		$id = $_GET['id'];

		$model = LinkModel::model()->findByPk( $id );
		if ( !( $model instanceof LinkModel ) ) {
			Yii::app()->user->setFlash( 'error', "<strong>Error</strong>. Banner yang ingin Anda delete tidak ada" );
		} else {
			if( $model->delete() ) {
				Yii::app()->user->setFlash( 'success', "Banner $model->name berhasil didelete." );
				
				// Delete Image
				$filename = dirname(dirname(Yii::app()->basePath)) . self::UPLOAD_DIR . '/' . $model->name;
				if ( file_exists( $filename ) ) {
					@unlink( $filename );
				}
			}
		}

		$this->redirect( 'index.php' );
	}

	public function actionActivate()
	{
		$id = $_GET['id'];

		$model = LinkModel::model()->findByPk( $id );
		if ( !( $model instanceof LinkModel ) ) {
			Yii::app()->user->setFlash( 'error', "<strong>Error</strong> Banner yang Anda cari tidak ditemukan" );
		} else {
			$statuses = array('Aktif', 'Non-aktif');

			$status = $model->status;
			$model->status = $status? 0: 1;
			$model->save();
			Yii::app()->user->setFlash( 'success', "Banner '{$model->name}' berhasil di {$statuses[$status]}kan" );
		}

		$this->redirect( 'index.php' );
	}

	public function getText($serial)
	{
		$array = @unserialize($serial);
		if ( is_array($array) ) {
			$result = $array["text"];
		}
		return $result;
	}

	public function getPosition($target)
	{
		$positions = LinkModel::getListPosition();
		$result = $positions[$target];

		return $result;
	}

	public function getWidth($target)
	{
		$widths = array(
			1 => 655,
			2 => 288,
			3 => 655,
			4 => 288
		);

		return $widths[$target];
	}
}
