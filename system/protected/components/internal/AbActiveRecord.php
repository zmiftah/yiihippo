<?php 

class AbActiveRecord extends CActiveRecord 
{

	protected $tbl_prefix = null;

	final public function tableName() 
	{
		if ($this->tbl_prefix === null) {
			$this->tbl_prefix = Yii::app()->params['tablePrefix'];
		}

		return ($this->tbl_prefix . $this->_tableName());
	}

	protected function _tableName() 
	{
		return parent::tableName();
	}

	public function getArrayDataProvider($pagination, $sorting) 
	{
    return new CArrayDataProvider( $this->findAll(), array(
      'pagination' => $pagination,
      'sort' => $sorting
    ));
  }

  protected function beforeSave()
  {
  	return parent::beforeSave();
  }
}