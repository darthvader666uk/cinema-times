<?php
	class cinema {
		private $cinema;

		public function __construct() {
			//get cinema
			$this->cinema = $this->loadCinema();
		}

		public function getCinema($cinema,$id){
			return $this->cinema[$cinema][$id];
		}

		public function getAllCinema() {
			return $this->cinema;
		}

		private function loadCinema() {
			$cinema = require(CONFIG_DIR.'/cinema-listing.php');
			return $cinema;
		}
	}
?>