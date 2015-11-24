<?php
class World {
	private $width;
	private $height;

	protected $map;

	public function __construct($width = 10, $height = 10) {
		$this->createMap($width, $height);
	}

	private function createMap($width, $height) {
		$this->width = $width;
		$this->height = $height;

		$this->map = new SplObjectStorage();
	}

	public function getWidth() {
		return $this->width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function getAllAnimals() {
		$clone = clone $this->map;

		return $clone;
	}

	public function addAnimal(Animal $animal) {
		$map = $this->getAllAnimals();

		if (!$this->isInsideMap($animal->getX(), $animal->getY())) {
			$animalName = get_class($animal);

			throw new Exception("Object {$animalName} in {$animal->getX()}, {$animal->getY()} outside from map!");
		}

		if ($objectName = $this->determineTheObject($animal->getX(), $animal->getY())) {
			throw new Exception("In this coordinate ({$animal->getX()}, {$animal->getY()}) already have it object - {$objectName}");
		}

		$this->map->attach($animal);

		$animal->returnWorldToTheAnimal($this);
	}

	public function removeAnimalFromMap(Animal $animal) {
		$this->map->detach($animal);

		$animal->deleteWorldFromTheAnimal();
	}

	public function overviewWorld(Animal $animal) {
		$map = $this->getAllAnimals();

		$overview = new SplObjectStorage();

		foreach($map as $object) {
			if ($object === $animal) {
				continue;
			}

			if ($this->calculateDistance($animal, $object) <= $animal->getView()) {
				$overview->attach($object);	
			}
		}

		return $overview;
	}

	public function searchAnimalsAroundByType(Animal $animal, array $types) {
		$overview = $this->overviewWorld($animal);

		$search = new SplObjectStorage();

		foreach($overview as $object) {
			foreach ($types as $type) {

				if (get_class($object) == $type) {
					$search->attach($object);
				}
			}	
		}

		return $search;
	}


	public function isInsideMap($x, $y) {
		if ($x > $this->width or $x < 1 or $y > $this->height or $y < 1) {
			//throw new Exception("x or y are outside of the border map");

			return false;
		}

		return true;
	}

	public function determineTheObject($x, $y) {
		foreach ($this->getAllAnimals() as $object) {
			if ($x == $object->getX() and $y == $object->getY()) {
				return $object;
			}
		}

		return false;
	} 

	public function calculateDistance($firstObject, $secondObject) {
		$distance = max(abs($firstObject->getX() - $secondObject->getX()), abs($firstObject->getY() - $secondObject->getY()));

		return $distance;
	}

	public function moveAllAnimals() {
		$animals = $this->getAllAnimals();

		foreach ($animals as $animal) {		
			if (!$animal->isItDie()) {
				$animal->move();
			}		
		}
	}
}