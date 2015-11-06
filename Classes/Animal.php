<?php
abstract class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	protected $die;

	protected $world;

	public function __construct($x = 0, $y = 0, $view = 1, $speed = 1) {
		$this->view = $view;
		$this->speed = $speed;

		$this->x = $x;
		$this->y = $y;

		$this->die = false;
	}

	public function returnWorldToTheAnimal($world) {
		$this->world = $world;
	}

	public function deleteWorldFromTheAnimal() {
		$this->world = false; //Так правильно?
	}

	public function getCoordinate() {
		return ['x' => $this->x, 'y' => $this->y];
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}

	public function getView() {
		return $this->view;
	}

	public function getSpeed() {
		return $this->speed;
	}

	public function getFears() {
		return $this->fears;
	}

	public function getTracks() {
		return $this->tracks;
	}

	public function isItDie() {
		return $this->die;
	}

	//You must return the symbol of the animal. 
	//return "🐒";
	abstract function getSymbol();

	public function getWorld() {
		return $this->world;
	}  

	public function searchAnimalsAroundByType(Animal $animal, array $types) {
		$overview = $this->getWorld()->overviewWorld($animal);

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

	public function foundTheNearestAnimal($search) {
		$animals = array();

		foreach ($search as $object) {
			$distance = $this->getWorld()->calculateDistance($this, $object);

			$animals[] = array('object' => $object, 'distance' => $distance); 
		}

		usort($animals, function($a, $b) {
		    if ($a['distance'] == $b['distance']) {
			        return 0;
			    }
			    
			    return ($a['distance'] < $b['distance']) ? -1 : 1;
			}
		);	

		$nearestAnimal = array_shift($animals);

		return $nearestAnimal['object'];	
	}

	abstract function getAllMoves($x, $y);

	public function isItNotOneOfTrack($x, $y, $tracks) {
		$object = $this->getWorld()->determineTheObject($x, $y);

		if ($object) {
			foreach ($tracks as $track) {
				if (get_class($object) == $track) {
					return false;
				}
			}
		}

		return $object;
	}

	public function isItCorner($x, $y) {
		$maxCountOfMoves = (($this->getSpeed() * 2) + 1)**2;

		$countMovesFromThisCoordinate = count($this->getAllMoves($x, $y));

		if ($countMovesFromThisCoordinate > ($maxCountOfMoves / 2)) {
			return false;
		}

		return true;
	}

	public function howManyMovesWillDoAnimal(Animal $animal, $distance) {
		if ($distance == 0) {
			return $distance;
		}

		$movesCount = ceil($distance / $animal->getSpeed());

		return $movesCount;
	}

	abstract function rateMoves($moves, $search);

	public function chooseTheMovement($ratedMoves) {
		usort($ratedMoves, function($a, $b) {
		    if ($a['score'] == $b['score']) {
			        return 0;
			    }
			    
			    return ($a['score'] > $b['score']) ? -1 : 1;
			}
		);

		$ratedMoves = array_shift($ratedMoves);

		return $ratedMoves;
	
	}

	abstract public function move();

	public function KillTheAnimal() {
		$this->die = true;

		$this->getWorld()->removeAnimalFromMap($this);

		return true;
	}
}