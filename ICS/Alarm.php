<?php
namespace ICS;
/*
Class title: ICS_EventAlarm
Class URI: https://github.com/AsgeirSH/ics-gen
Author: Asgeir S Hustad
Version: 0.1
Author URI: https://github.com/AsgeirSH

*/

use DateTime;
use Exception;

class Alarm {
	var $triggerType = "PRIOR";
	var $trigger;
	var $action;
	var $duration;
	var $repeat = false;
	var $description;
	var $summary;
	var $attendee;
	var $attach;

	public function __construct() {

	}

	/** 
	 * TRIGGER is required for all alarms.
	 * Param varies based on triggerType.
	 * Param can be a negative value (in minutes), positive value (in minutes) or a UTC timestamp.
	 * Negative value is minutes before, positive value is minutes after.
	 */
	public function setTrigger($trigger) {
		$this->trigger = $trigger;
		return $this;
	}

	/**
	 *	TriggerType can be either PRIOR, END or ABSOLUTE.
	 *	Default is PRIOR, which means that setTrigger should be in minutes relative to event-start.
	 * 	END means that setTrigger should be in minutes before or after event-end.
	 * 	ABSOLUTE means that setTrigger should be a UTC-formatted timestamp.
	 */
	public function setTriggerType($type) {
		$this->triggerType = $type;
		return $this;
	}

	/**
	 * Action is required for all alarms.
	 * String, can be one of AUDIO, DISPLAY, EMAIL or PROCEDURE
	 */
	public function setAction( $action ) {
		$this->action = $action;
		return $this;
	}

	/**
	 * Attachment is required for AUDIO and PROCEDURE actions and optional for EMAIL actions.
	 */
	public function setAttachment( $attachment ) {
		$this->attachment = $attachment;
		return $this;
	}

	/**
	 * Description is required for DISPLAY and EMAIL actions.
	 */
	public function setDescription( $description ) {
		$this->description = $description;
		return $this;
	}

	/**
	 * Repeat is required if duration is set to provide repeated alarms.
	 * Param is an integer number, the number of times to repeat the alarm at DURATION intervals.
	 */
	public function setRepeat($repeat) {
		$this->repeat = $repeat;
		return $this;
	}

	/**
	 * Duration is required if repeat is set to provide repeated alarms.
	 * Param is an integer number, the amount of minutes between alarms.
	 */
	public function setDuration($duration) {
		$this->duration = $duration;
		return $this;
	}	

	/**
	 * Summary is required for EMAIL actions.
	 * This is what will be the email subject line.
	 */
	public function setSummary( $summary ) {
		$this->summary = $summary;
		return $this;
	}

	/**
	 * Attendees are required for EMAIL actions.
	 * Param must be a list of e-mail-addresses to receive the warning.
	 */
	public function setAttendees( $attendees ) {
		$this->attendees = $attendees;
		return $this;
	}

	public function write() {
		switch($this->action) {
			case "DISPLAY":
				$alarm = 'BEGIN:VALARM' . "\r\n"		# Beginning of field
						.$this->_buildTriggerField() . "\r\n"	# Trigger
						.($this->repeat != false ? 'REPEAT:'.$this->repeat . "\r\n" : '')
						.($this->duration != false ? $this->_buildDurationField() . "\r\n" : '')
						.'ACTION:'.$this->action . "\r\n"
						.'DESCRIPTION:'.$this->description . "\r\n"
						.'END:VALARM'. "\r\n";			
				break;
			case "AUDIO":
				throw new Exception("AUDIO-action is not implemented yet!");
				break;
			case "EMAIL":
				throw new Exception("EMAIL-action is not implemented yet!");
				break;
			case "PROCEDURE":
				throw new Exception("PROCEDURE-action is not implemented yet!");
				break;
		}
		return $alarm;
	}

	private function _buildTriggerField() {
		$trigger = '';
		switch ($this->triggerType) {
			case "END":
				if($this->trigger > 0)
					$trigger = 'TRIGGER;RELATED=END:P'.$this->trigger.'M';
				else $trigger = 'TRIGGER;RELATED=END:-P'.$this->trigger*(-1).'M';
				break;
			case "ABSOLUTE":
				$trigger = 'TRIGGER;VALUE=DATE-TIME:'.$this->trigger;
				break;
			case "PRIOR": 
			default:
				if($this->trigger > 0)
					$trigger = 'TRIGGER:PT'.$this->trigger.'M';
				else $trigger = 'TRIGGER:-PT'.$this->trigger*(-1).'M';
		}
		return $trigger;
	}

	private function _buildDurationField() {
		$duration = '';
		if ($this->duration > 0 )
			$duration = 'DURATION:PT'.$this->duration.'M';
		else 
			$duration = 'DURATION:-PT'.$this->duration.'M';
		return $duration;
	}
}