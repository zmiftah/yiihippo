<?php

class PostTermModel extends AbActiveRecord
{
	public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'postterm';
  }

  public function primaryKey() 
  {
    return array('post_id', 'taxo_id');
  }

  public function relations()
  {
    return array(
      'post' => array( self::HAS_MANY, 'PostModel', 'post_id'),
      'taxo' => array( self::HAS_MANY, 'TaxonomyModel', 'taxo_id'),
    );
  }

  public static function getPostTerms($postId, $taxonomy)
  {
    $terms = PostTermModel::model()->findAll(array(
      'condition'=>'post_id=:post',
      'params'=>array(':post'=>$postId)
    ));

    if ( count($terms)>0 && $terms[0]->taxo_id == $taxonomy ) {
      $list = $terms[0]->terms;
    } elseif ( count($terms)>1 && $terms[1]->taxo_id == $taxonomy ) {
      $list = $terms[1]->terms;
    } else {
      return '';
    }

    $retVal = explode(',', $list);
    $retVal = "'".implode("','", $retVal)."'";

    if ($taxonomy == TaxonomyModel::TAG) {
      $retVal = self::getTagsName($list);
    }

    return $retVal;
  }

  public static function getTagsName($Ids)
  {
    if( empty($Ids) ) return '';

    $tag = Yii::app()->db->createCommand()
    ->select("GROUP_CONCAT(CONCAT('\"',name,'\"')) as tags")
    ->from('terms')
    ->where("term_id IN ($Ids)")
    ->queryRow();

    return is_array($tag) ? $tag['tags'] : '';
  }
}