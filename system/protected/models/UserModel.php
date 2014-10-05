<?php 

class UserModel extends AbActiveRecord 
{
	public static function model($className=__CLASS__) 
	{
    return parent::model( $className );
  }

  public function _tableName() 
  {
    return 'users';
  }

  public function primaryKey() 
  {
      return 'user_id';
  }
}