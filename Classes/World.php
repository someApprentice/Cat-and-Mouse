<?php
class World {
	private $map = array();

	public function __construct() {
		$this->createMap();
	}

	public function createMap($m = 10, $n = 10) {
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

	public function moveAnimal(Animal $animal) {
		$this->removeAnimalFromMap($animal);

		$animal->move();

		$this->addAnimalToMap($animal);
	}

	public function __destruct() {
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