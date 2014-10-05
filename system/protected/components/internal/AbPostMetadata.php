<?php 

class AbPostMetadata
{
	public function add($postId, $key, $value)
	{
		$result = Yii::app()->db
		->createCommand()
		->insert('metadata', array(
			'key'=>$key,
			'value'=>$value,
			'table'=>'posts',
			'table_id'=>$postId,
		));

		return $result;
	}

	public function update($postId, $key, $newValue)
	{
		$result = Yii::app()->db
		->createCommand()
		->update('metadata', array(
			'value'=>$newValue
		), 'key=:key AND table=:table AND table_id=:id', array(
			':key'=>$key, ':table'=>'posts', ':id'=>$postId
		));

		return $result;
	}

	public function delete($postId, $key)
	{
		$result = Yii::app()->db
		->createCommand()
		->delete('metadata', 'key=:key AND table=:table AND table_id=:id', 
			array(':key'=>$key, ':table'=>'posts', ':id'=>$postId)
		);

		return $result;
	}

	public function getAll($postId)
	{
		$rows = Yii::app()->db->createCommand()
		->from('metadata')
		->where('table=:table', array(':table'=>'posts'))
		->andWhere('table_id=:id', array(':id'=>$postId))
		->queryAll();

		return $rows;
	}

	public function getKeys($postId)
	{
		$keys = Yii::app()->db->createCommand()
		->select('key')
		->from('metadata')
		->where('table=:table', array(':table'=>'posts'))
		->andWhere('table_id=:id', array(':id'=>$postId))
		->queryAll();

		return $keys;
	}

	public function get($postId, $key)
	{
		$value = Yii::app()->db->createCommand()
		->select('value')
		->from('metadata')
		->where('table=:table', array(':table'=>'posts'))
		->andWhere('table_id=:id', array(':id'=>$postId))
		->andWhere('key=:key', array(':key'=>$key))
		->queryScalar();

		return $value;
	}
}