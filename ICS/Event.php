<?php
/* 
Class Name: ICS_Event
Class URI: https://github.com/mariusmandal/ics-gen
Author: Marius Mandal 
Version: 0.1 
Author URI: http://www.mariusmandal.no
*/
class ICS_Event {
	
	var $name;
	var $start;
	var $stop;
	var $description;

	public function __construct( $name ) {
		$this->name = $name;
	}
	
	public function setName( $name ) {
		$this->name = $name;
	}
	
	public function setStart( $start ) {
		$this->start = $start;
	}
	
	public function setStop( $stop ) {
		$this->stop = $stop;
	}
	
	public function setDescription( $description ) {
		$this->description = $description;
	}
	
}