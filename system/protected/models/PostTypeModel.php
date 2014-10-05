<?php 

class PostTypeModel extends AbActiveRecord 
{
  const TYPE_PAGE     = 1;
  const TYPE_ARTICLE  = 2;
  const TYPE_REVISION = 3;
  const TYPE_PRIVATE  = 4;
  const TYPE_TRASH    = 5;

  public static function model( $className=__CLASS__ ) {
    return parent::model( $className );
  }

  public function _tableName() {
    return 'posttype';
  }

  public function primaryKey() {
    return 'posttype_id';
  }

  public function relations() {
    return array(
    	'post' => array( self::HAS_MANY, 'PostModel', 'posttype_id' ),
    );
  }

  public static function getPostTypeId($postType)
  {
    $types = array(
      'page' => self::TYPE_PAGE,
      'article' => self::TYPE_ARTICLE,
      'revision' => self::TYPE_REVISION,
      'private' => self::TYPE_PRIVATE,
      'trash' => self::TYPE_TRASH
    );

    $Id = array_key_exists($postType, $types) ? $types[$postType] : 0;
    return $Id;
  }
}