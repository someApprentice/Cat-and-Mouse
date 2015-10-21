<?php
abstract class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	protected $die;

	public $symbol;

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

	abstract function getAllMoves();

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

	public function KillAnimal() {
		$this->die = true;
	}
}