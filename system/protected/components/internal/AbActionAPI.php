<?php 

class AbActionAPI extends CApplicationComponent
{
	private $unique = array();
	private $contents = array();

	public function add($event, $funcname, $priority=0, $args=null) 
	{
		list($key, $fname) = $this->createUnique( $event );

		$this->unique[$fname]         = $key;
		$this->contents[$event][$key] = array(
			'p' => $priority,
			'f' => $funcname,
			'a' => $args
		);
	}

	public function has($event, $funcname) 
	{
		$fname = $this->createName($event, $funcname);
		return !empty( $this->unique[$fname] );
	}

	public function execute($event) 
	{
		foreach ( $this->contents[$event] as $key => $func ) {
			if ( !is_null($func['f']) ) {
				call_user_func_array( $func['f'], $func['a'] );
			}
		}
	}

	public function remove($event, $funcname, $priority, $args) 
	{
		# code...
	}

	protected function createUnique($event, $funcname)
	{
		$n = count( $this->contents[$event] );
		$hash = PseudoCrypt::hash($n, 10);
		$name = $this->createName($event, $funcname);

		return array( 'k'=>$hash, 'n'=>$name );
	}

	protected function createName($event, $funcname)
	{

		return $event . '_' . $funcname;
	}
}