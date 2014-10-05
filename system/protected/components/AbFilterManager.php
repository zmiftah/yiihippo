<?php

class AbFilterManager extends CApplicationComponent
{
	protected $events = array();

	// Event Access
	// 
	public function registerEvent($owner, $eventName, $event)
	{
		$this->events[$eventName] = $owner;
		$owner->$eventName = $event;
	}

	public function doEvent($owner, $eventName)
	{
		$event = new CEvent($owner);
		$owner->$eventName($event);
	}
}