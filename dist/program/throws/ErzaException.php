<?php
	class ErzaException extends Exception {
		private $ip, $date;

		public function __construct($msg, $ip) {
			parent::__construct($msg);
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone('Europe/Prague'));
			$this->date = $date->format('M jS Y :: h:i:s A');
			$this->ip = $ip;
		}

		public function getDate() {
			return $this->date;
		}

		public function getIP() {
			return $this->ip;
		}
	}