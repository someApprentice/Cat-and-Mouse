<?php
class World {
	private $map = array();

	public function __construct() {
		$this->createMap();
	}

	private function createMap($m = 10, $n = 10) {
		$this->map = array_fill(0, $m, array_fill(0, $n, ''));
	}

	public function getMap() {
		return $this->map;
	}

	public function addAnimalToMap(Animal $animal) {
		$coordinate = $animal->getCoordinate();

		$this->map[$coordinate['y']][$coordinate['x']] = $animal;
	}

	public function removeAnimalFromMap(Animal $animal) {
		$coordinate = $animal->getCoordinate(); //копипаста

		$this->map[$coordinate['y']][$coordinate['x']] = '';
	}

	public function moveAnimal(array $from, array $to) {
		if (!isset($from['x']) and !isset($from['y']) and !isset($to['x']) and !isset($to['y'])) {
			return false;
		}

		$this->map[$to['y']][$to['x']] = $this->map[$from['y']][$from['x']];

		$this->map[$from['y']][$from['x']] = '';
	}

	public function printMap() {
		foreach ($this->map as $y => $x) {
			foreach ($x as $value) {
				if ($value == '') {
					echo ' _ ';
				} else {
					echo ' @ ';
				}
			}

			echo "<br>";
		}
	}	
}