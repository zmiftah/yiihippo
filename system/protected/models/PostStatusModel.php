<?php 

class PostStatusModel extends AbActiveRecord 
{
  const STATUS_DRAFT   = 1;
  const STATUS_PUBLISH = 2;
  
  public static function model($className=__CLASS__) {
    return parent::model( $className );
  }

  public function _tableName() {
    return 'poststatus';
  }

  public function primaryKey() {
    return 'status_id';
  }

   public function relations() {
    return array(
      'status' => array( self::HAS_MANY, 'PostModel', 'status' ),
    );
  }
}