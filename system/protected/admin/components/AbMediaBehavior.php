<?php 

class AbMediaBehavior extends CBehavior
{
  public function createThumbnail($resultFile, $w, $h, $changeName=true)
  {
    try {
      $info = pathinfo($resultFile);
      $thumbFile = $info['dirname'].'/'.$info['filename'];
      if ($changeName) $thumbFile .= '-'.$w.'x'.$h;
      $thumbFile .= '.'.$info['extension'];

      $thumb = Yii::app()->phpThumb->create($resultFile);
      $thumb->adaptiveResize($w, $h);
      $thumb->save($thumbFile);
      return true;
    } catch (Exception $e) {
      return false;
    }
  }

	public function getUploadPath($new_dir='')
  {
    $path = Yii::getPathOfAlias('uploadpath').'/media';
    if ( $path ) {
      $path = empty($new_dir) ? $path : $path.'/'.$new_dir;
      @mkdir($path, 0777, true);
    }

    return $path ? $path : '';
  }

  public function getFileName($name, $ext)
  {
    $info = pathinfo($name);
    return str_replace($ext, '', $info['filename']) . "$ext";
  }

  public function getDimensions($filename, $filetype)
  {
    $image = null;
    switch ($filetype) {
      case 'image/gif':
        $image = imagecreatefromgif($filename);
        break;
      case 'image/jpeg':
      case 'image/pjpeg': 
        $image = imagecreatefromjpeg($filename);
        break;
      case 'image/png': 
        $image = imagecreatefrompng($filename);
        break;
      case 'image/bmp':
        $image = imagecreatefromwbmp($filename);
    }

    if ($image != null) {
      return array(
        'w'=>imagesx($image),
        'h'=>imagesy($image)
      );
    }

    return null;
  }
}