<?php
abstract class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	protected $die;

	protected $world;

	protected $fears;
	protected $tracks;

	public function __construct($x = 0, $y = 0, $view = 1, $speed = 1) {
		$this->view = $view;
		$this->speed = $speed;

		$this->x = $x;
		$this->y = $y;

		$this->die = false;
	}

	//You must return symbol of animal. 
	//return "🐒";
	abstract function getSymbol();

	abstract function getAllMoves($x, $y);

	abstract function rateMoves($moves, $search);

	abstract public function move();

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

	public function isItDie() {
		return $this->die;
	}

	public function makeDead() {
		$this->die = true;

		$this->getWorld()->removeAnimalFromMap($this);
	}

	public function returnWorldToTheAnimal(World $world) {
		$this->world = $world;
	}

	public function deleteWorldFromTheAnimal() {
		$this->world = null;
	}

	protected function getFears() {
		return $this->fears;
	}

	protected function getTracks() {
		return $this->tracks;
	}

	protected function getWorld() {
		return $this->world;
	}  

	protected function foundTheNearestAnimal($search) {
		$animals = array();

		foreach ($search as $object) {
			$distance = $this->getWorld()->calculateDistance($this, $object);

			$animals[$distance] = $object; 
		}

		ksort($animals);

		$nearestAnimal = array_shift($animals);

		return $nearestAnimal;	
	}

	protected function isItNotOneOfTrack($x, $y, $tracks) {
		$object = $this->getWorld()->determineTheObject($x, $y);

		if ($object) {
			foreach ($tracks as $track) {
				if (get_class($object) == $track) {
					return true;
				}
			}
		}

		return $object;
	}

	protected function isItCorner($x, $y) {
		$maxCountOfMoves = (($this->getSpeed() * 2) + 1)**2;

		$countMovesFromThisCoordinate = count($this->getAllMoves($x, $y));

		if ($countMovesFromThisCoordinate > ($maxCountOfMoves / 2)) {
			return false;
		}

		return true;
	}

	protected function howManyMovesWillDoAnimal(Animal $animal, $distance) {
		if ($distance == 0) {
			return $distance;
		}

		$movesCount = ceil($distance / $animal->getSpeed());

		return $movesCount;
	}

	protected function chooseTheMovement($ratedMoves) {
		usort($ratedMoves, function($a, $b) {
		    if ($a['score'] == $b['score']) {
			        return 0;
			    }
			    
			    return ($a['score'] > $b['score']) ? -1 : 1;
			}
		);

		$bestMove = array_shift($ratedMoves);

		return $bestMove;
	}
}