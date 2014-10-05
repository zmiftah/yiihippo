<?php

class MediaHelper
{
  public static function getThumbnail($data, $width=32, $height=32)
  {
    $name = $data['name'];
    $url  = $data['url'];
    $info = pathinfo($url);

    $baseUrl   = Yii::app()->baseUrl;
    $baseDir   = dirname(dirname(Yii::app()->basePath));
    $thumbSize = $original ? '' : '-'.$width.'x'.$height;
    $thumbName = $info['dirname'].'/'.$info['filename'].$thumbSize.'.'.$info['extension'];
    
    if ( file_exists($baseDir.$thumbName) ) {
      $imageTag  = '<img src="'.$baseUrl.$thumbName.'" width="'.$width.'" height="'.$height.'" alt="'.$name.'" title="'.$name.'" />';
    } else {
      $placeholdr = 'http://placehold.it/'.$width.'x'.$height.'';
      $imageTag   = '<img src="'.$placeholdr.'" width="'.$width.'" height="'.$height.'" alt="No Media" />';
    }

    return $imageTag.' '.$data['name'];
  }

  public static function getFileThumbnail($data, $width=32, $height=32)
  {
    $name = $data['name'];
    $url  = $data['url'];
    $info = pathinfo($url);

    $baseUrl   = Yii::app()->baseUrl;
    $baseDir   = dirname(dirname(Yii::app()->basePath));
    $thumbSize = '-'.$width.'x'.$height;
    $thumbName = $info['dirname'].'/'.$info['filename'].$thumbSize.'.'.$info['extension'];
    
    if ( file_exists($baseDir.$thumbName) ) {
      $image  = $baseUrl.$thumbName;
    }

    return $image;
  }
}