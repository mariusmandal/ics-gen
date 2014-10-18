<?php
namespace ICS;

class Calendar {
	var $filepath = 'ics-gen-temp/noname.ics';
	var $name;
	var $prodid = '-//mariusmandal.no//ics-gen//NO';
	var $calendar_type = 'GREGORIAN';
	
	var $events = [];

	public function __construct( $name ) {
		$this->name = $name;
	}
	
	public function setDescription( $description ) {
		$this->description = $description;
	}
	
	public function setOwner( $owner, $website, $language='NO' ) {
		$this->prodid = '-//'. $website .'//'. $owner .'//'. $owner;
	}
	
	public function addEvent( $event ) {
		$this->events[] = $event;
	}
	
	public function write( $full_path, $download_url ) {
		$this->filepath = $full_path;
		
		$this->_fopen();
		$this->_writeHeader();
		$this->_writeEventList();
		$this->_writeFooter();
		$this->_fclose();
		
		return $download_url;
	}
	
	private function _writeEventList() {
		foreach( $this->events as $event ) {
			fwrite( $this->file, $event->write( $this->prodid ) );
		}
	}
	
	
	private function _writeHeader() {
		fwrite( $this->file, 
			 'BEGIN:VCALENDAR' ."\r\n"
			.'VERSION:2.0' ."\r\n"
			.'CALSCALE:'. $this->calendar_type ."\r\n"
			.'METHOD:PUBLISH' ."\r\n"
			.'X-WR-CALNAME:'. $this->name ."\r\n"
			.'PRODID:'. $this->prodid ."\r\n"
			);
	}
	
	private function _writeFooter() {
		fwrite( $this->file, 'END:VCALENDAR' ."\r\n" );
	}
	
	private function _fopen( ) {
		$this->file = fopen( $this->filepath, 'w' );
	}
	
	private function _fclose() {
		fclose( $this->file );	
	}
}