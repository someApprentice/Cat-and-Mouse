<?php
class World {
	private $m;
	private $n;

	protected $map = array();

	public function __construct() {
		$this->createMap();
	}

	private function createMap($m = 10, $n = 10) {
		$this->m = $m;
		$this->n = $n;

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

		//Неудачная попытка не дать объекту выйти за рамки карты
		switch ($to['y']) { 
			case ($to['y'] > $this->m):
				$to['y'] = $to['y'] - ($to['y'] - $this->m);
			break;

			case ($to['y'] < 0):
				$to['y'] = $to['y'] - ($to['y'] - $from['y']);
			break;
			
			default:
				$to['y'] = $to['y'];
			break;
		}


		switch ($to['x']) {
			case ($to['x'] > $this->m):
				$to['x'] = $to['x'] - ($to['x'] - $this->m);
			break;

			case ($to['x'] < 0):
				$to['x'] = $to['x'] - ($to['x'] - $from['x']);
			break;
			
			default:
				$to['x'] = $to['x'];
			break;
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
					echo ' '. $value->symbol . ' ';
				}
			}

			echo "<br>";
		}
	}	
}