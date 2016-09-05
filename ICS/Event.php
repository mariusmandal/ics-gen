<?php
namespace ICS;
/* 
Class title: ICS_Event
Class URI: https://github.com/mariusmandal/ics-gen
Author: Marius Mandal 
Version: 0.1 
Author URI: http://www.mariusmandal.no
*/

use DateTime;

class Event {
	
	var $title;
	var $start;
	var $stop;
	var $description = '';
	var $location = '';
	var $owner = 'marius@mariusmandal.no';
	var $status = 'CONFIRMED';
	// Array of ICS\Alarm-objects
	var $alarms;
	
	private $dateFormat = 'Ymd';

	public function __construct( $title ) {
		$this->title = $title;
		$this->start = new DateTime();
		$this->stop = new DateTime();
		$this->alarms = array();
	}
	
	public function setTitle( $title ) {
		$this->title = $title;
		return $this;
	}
	
	public function setStart( $start ) {
		$this->start = $start;
		return $this;
	}
	
	public function setStop( $stop ) {
		$this->stop = $stop;
		return $this;
	}
	
	public function setDescription( $description ) {
		$this->description = $description;
		return $this;
	}
	
	public function setStatus( $status ) {
		$this->status = $status;
	}
	
	public function setLocation( $location ) {
		$this->location = $location;
	}
	
	public function addAlarm($alarm) {
		$this->alarms[] = $alarm;
	}

	public function write( $calendarProdID ) {
		$event = 'BEGIN:VEVENT' ."\r\n"
				.'DTSTART;VALUE=DATE:'. $this->start->format( $this->dateFormat ) ."\r\n"
				.'DTEND;VALUE=DATE:'. $this->stop->format( $this->dateFormat ) ."\r\n"
				.'SUMMARY:'. $this->title ."\r\n"
				.'LOCATION: '. $this->location ."\r\n"
				.'UID: #insertIDhere'  ."\r\n"
				.'SEQUENCE:0' ."\r\n"
				.'DESCRIPTION:'. $this->description ."\r\n"
				.'STATUS:'. $this->status ."\r\n"
				.$this->_writeAlarms()
				.'END:VEVENT' ."\r\n"
				;
		$id = sha1( $event .'@'. $calendarProdID );
		return str_replace('#insertIDhere', $id, $event);
	}

	private function _writeAlarms() {
		$text = '';
		foreach ($this->alarms as $alarm) {
			$text .= $alarm->write();
		}
		return $text;
	}
	
}