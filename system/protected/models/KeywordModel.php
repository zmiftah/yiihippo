<?php 

class KeywordModel extends AbActiveRecord 
{
  const STATUS_ADDED    = 0;
  const STATUS_SUBMITED = 1;

	public static function model($className=__CLASS__) 
  {
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'keywords';
  }

  public function primaryKey() 
  {
    return 'id';
  }

  public function relations() 
  {
    return array(
    	'post' => array( self::HAS_MANY, 'PostModel', 'id' ),
    );
  }

  public function scopes()
  {
    return array(
      'added'=>array(
        'condition'=>"status='0'",
      ),
      'submited'=>array(
        'condition'=>"status='1'",
      )
    );
  }

  public static function getMap($id='', $useId = true)
  {
    $keywords = empty($id)
      ? self::model()->added()->findAll()
      : self::model()->findAll('id=:id', array(':id'=>$id));

    $data = array( '' => '--- Pilih Keyword ---' );
    foreach ($keywords as $kwd) {
      $index = $useId ? $kwd->id : $kwd->name;
      $data[$index] = $kwd->name;
    }

    return $data;
  }
}