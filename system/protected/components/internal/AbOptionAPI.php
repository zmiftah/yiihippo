<?php 

class AbOptionAPI extends CApplicationComponent 
{
	private static $_command;

	protected function createCommand() 
	{
		if ( !self::$_command instanceof CDbCommand ) {
			self::$_command = Yii::app()->db->createCommand();
		}
		return self::$_command;
	}

	public function add($option, $value, $config=null, $serialized=false) 
	{
		$cmd = $this->createCommand();

		// Check Jika Ada
		$row = $cmd->select('*')->from('options')
		->where('name=:name', array(':name'=>$option))
		->queryRow();

		if ( is_array($row) ) {
			$this->update($option, $value, $serialized);
		} else {
			$cmd->insert('options', array(
				'name'   => $option,
				'value'  => $this->sanitizeValue($value, 'set', $serialized),
				'config' => $config,
			));
			$cmd->reset();
		}

		return $this;
	}

	protected function update($option, $newvalue, $serialized=false) 
	{
		$cmd = $this->createCommand();
		$result = $cmd->update('options', array(
		    'value' => $this->sanitizeValue($newvalue, 'set', $serialized),
		), 'name=:name', array(':name'=>$option));
		$cmd->reset();

		return $result;
	}

	public function delete($option) 
	{
		$cmd = $this->createCommand();
		$cmd->delete('options', 
			'name=:name', 
			array( ':name'=>$option )
		);
		$cmd->reset();
	}

	public function get($option, $default = false) 
	{
		$cmd   = $this->createCommand();
		$value = $cmd->select('value')
    ->from('options')
    ->where('name=:name', array(':name'=>$option))
    ->queryRow();
    $result = is_array($value) ? $value['value'] : $default;

	  return $this->sanitizeValue($result, 'get', false);
	}

	protected function sanitizeValue($value, $type, $serialized)
	{
		if ( $type == 'set' && $serialized ) {
			$value = serialize($value);
		} elseif ( $type == 'get' ) {
			$result = @unserialize($value);
			if ( $result ) return $result;
		}

		return $value;
	}
}