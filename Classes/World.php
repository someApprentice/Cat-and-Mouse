<?php
class World {
	private $x;
	private $y;

	protected $map;

	public function __construct() {
		$this->createMap();
	}

	private function createMap() {
		$this->map = new SplObjectStorage();
	}

	public function getMap() {
		return $this->map;
	}

	public function addAnimal(Animal $animal) {
		$map = $this->getMap();

		foreach ($map as $object) {
			if ($animal->getX() == $object->getX() and $animal->getY() == $object->getY()) {
				throw new Exception("In this coordinate already have it object");

				return false;
			}

			$this->map->attach($animal);

			$animal->returnWorldToTheAnimal($this);
		}
	}

	public function removeAnimalFromMap(Animal $animal) {
		$this->map->detach($animal);
	}

	//Я много думал что передавать в эту переменную и решил передать именно Животное от которого будет совершаться обзор, а не значения координат.
	//Мне показалось так наглядней и удобней в плане написания кода. Поправь пожалуйста если не правильно.
	public function overviewWorld(Animal $animal) {
		$map = $this->getMap();

		$overview = new SplObjectStorage();

		foreach($map as $object) {
			if ((($object->getX() >= $animal->getX() - $animal->view) and ($object->getX() <=  $animal->getX() + $animal->view)) and ($object->getY() >= $animal->getY() - $animal->view) and ($object->getY() <=  $animal->getY() + $animal->view)) {
					$overview->attach($object);
				}
			}
		}

		return $overview;
	}

	public function searchScaryAnimals(Animal $animal) {
		$overview = $this->overviewWorld($animal);

		$search = new SplObjectStorage();

		foreach($overview as $object) {
			foreach ($animal->fears as $fear) {
				if (get_class($object) == $fear) {
					$search->attach($object);
				}
			}	
		}

		return $search;
	}

	public function searchTrackedAnimals(Animal $animal) {
		$overview = $this->overviewWorld($animal);

		$search = new SplObjectStorage();
		
		foreach($overview as $object) {
			foreach ($animal->hunted as $hunt) {
				if (get_class($object) == $hunt) {
					$search->attach($object);
				}
			}	

		}

		return $search;
	}

	public function delimitation($x, $y) {
		if ($x > $this->x or $x < 0 or $y > $this->y or $y < 0) {
			throw new Exception("x or y are outside to the border of map");
		}
	}

	public function moveAnimal(array $from, array $to) {
	}

	public function printMap() {
	}	
}