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

	abstract function rateMove($x, $y);

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

	protected function foundTheNearestAnimal(object $search) {
		$animals = array();

		foreach ($search as $object) {
			$distance = $this->getWorld()->calculateDistance($this, $object);

			$animals[$distance] = $object; 
		}

		ksort($animals);

		$nearestAnimal = array_shift($animals);

		return $nearestAnimal;	
	}

	protected function isItNotOneOfTrack($x, $y, array $tracks) {
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

	//Берутся все ходы от текущей координаты
	//и если их количество меньше количества всех возможных ходов деленных на 2
	//(количество ходов из угла примерно в два раза меньше чем количество ходов из центра),
	//то возвращается true 
	protected function isItCorner($x, $y) {
		$mapX = $this->getWorld()->getWidth();
		$mapY = $this->getWorld()->getHeight();

		$isItCorner = (($x == $mapX and $y == $mapY) or ($x == 1 and $y == $mapY) or ($x == $mapX and $y == 1) or ($x == 1 and $y == 1));

		return $isItCorner;
	}

	protected function howManyMovesWillDoAnimal(Animal $animal, $distance) {
		if ($distance == 0) {
			return $distance;
		}

		$movesCount = ceil($distance / $animal->getSpeed());

		return $movesCount;
	}

	protected function rateMoves(array $moves) {
		$ratedMoves = array();

		foreach ($moves as $move) {
			$x = $move['x'];
			$y = $move['y'];

			$rate = $this->rateMove($move['x'], $move['y']);

			$ratedMoves[] = array(
				'x' => $x,
				'y' => $y,
				'score' => $rate
			);
		}

		return $ratedMoves;		
	}

	protected function chooseTheMovement(array $ratedMoves) {
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