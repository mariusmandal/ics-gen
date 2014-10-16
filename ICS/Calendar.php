<?php
/* 
Class Name: ICS_Calendar
Class URI: https://github.com/mariusmandal/ics-gen
Author: Marius Mandal 
Version: 0.1 
Author URI: http://www.mariusmandal.no
*/
class ICS_Calendar {
	
	var $name;
	
	var $events = [];

	public function __construct( $name ) {
		$this->name = $name;
	}
	
	public function addEvent( $event ) {
		$this->events[] = $event;
	}
	
	public function write( $filename ) {
		$this->_fopen();
		$this->_writeHeader();
		$this->_writeEventList();
		$this->_writeFooter();
		$this->_fclose();
	}
	
	private function _writeHeader() {
		
	}
	
	private function _fopen( $filename ) {
		$this->file = fopen( $filename, 'w' );
	}
	
	private function _fclose() {
		fclose( $this->file );	
	}
}