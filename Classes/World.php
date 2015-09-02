<?php
class World {
	private $x;
	private $y;

	protected $map = array();

	public function __construct() {
		$this->createMap();
	}

	private function createMap($x = 10, $y = 10) {
		$this->x = $x;
		$this->y = $y;

		$this->map = array_fill(0, $x, array_fill(0, $y, ''));
	}

	public function getMap() {
		return $this->map;
	}

	public function addAnimal(Animal $animal) {
		$coordinate = $animal->getCoordinate();

		if (!is_object($this->map[$coordinate['y']][$coordinate['x']])) {
			$this->map[$coordinate['y']][$coordinate['x']] = $animal;

			$animal->realizingTheWorld($this);
		}
	}

	public function removeAnimalFromMap(Animal $animal) {
		$coordinate = $animal->getCoordinate(); //копипаста

		$this->map[$coordinate['y']][$coordinate['x']] = '';
	}

	public function delimitation(array $from, array $to) {
		if ($to['x'] > ($this->x -1)) {
			$to['x'] = $this->x - 1;
		} elseif($to['x'] < 0) {
			$to['x'] = 0;
		}

		if ($to['y'] > ($this->y - 1)) {
			$to['y'] = $this->y - 1;
		} elseif ($to['y'] < 0) {
			$to['y'] = 0;
 		}

		return $to;
	}

	public function moveAnimal(array $from, array $to) {
		//$to = $this->delimitation($from, $to);

		if (is_object($this->map[$to['x']][$to['y']])) {
			$trappedAnimal = $this->map[$to['x']][$to['y']];

			$trappedAnimal->KillAnimal();
		}

		$this->map[$to['x']][$to['y']] = $this->map[$from['x']][$from['y']];

		$this->map[$from['x']][$from['y']] = '';
	}

	public function printMap() {
		foreach ($this->map as $x => $y) {
			foreach ($y as $key => $value) {
				if ($value == '') {
					echo $x . $key . " ";
				} else {
					echo ' '. $value->symbol . ' ';
				}
			}

			echo "<br>";
		}
	}	
}