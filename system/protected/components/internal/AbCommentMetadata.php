<?php 

class AbCommentMetadata
{
	public function add($commentId, $key, $value)
	{
		$result = Yii::app()->db
		->createCommand()
		->insert('metadata', array(
			'key'=>$key,
			'value'=>$value,
			'table'=>'comments',
			'table_id'=>$postId,
		));

		return $result;
	}

	public function update($commentId, $key, $newValue)
	{
		$result = Yii::app()->db
		->createCommand()
		->update('metadata', array(
			'value'=>$newValue
		), 'key=:key AND table=:table AND table_id=:id', array(
			':key'=>$key, ':table'=>'comments', ':id'=>$postId
		));

		return $result;
	}

	public function delete($commentId, $key)
	{
		$result = Yii::app()->db
		->createCommand()
		->delete('metadata', 'key=:key AND table=:table AND table_id=:id', 
			array(':key'=>$key, ':table'=>'comments', ':id'=>$postId)
		);

		return $result;
	}

	public function get($commentId, $key)
	{
		$value = Yii::app()->db->createCommand()
		->select('value')
		->from('metadata')
		->where('table=:table', array(':table'=>'comments'))
		->andWhere('table_id=:id', array(':id'=>$commentId))
		->andWhere('key=:key', array(':key'=>$key))
		->queryScalar();

		return $value;
	}
}