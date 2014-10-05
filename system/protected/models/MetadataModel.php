<?php 

class MetadataModel extends AbActiveRecord 
{
	public static function model($className=__CLASS__) 
	{
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'metadata';
  }

  public function primaryKey() 
  {
    return 'meta_id';
  }
}