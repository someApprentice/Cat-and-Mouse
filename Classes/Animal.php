<?php
abstract class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	protected $fears = array();
	protected $tracks = array();

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

	public function getSymbol() {
		return $this->symbol;
	}

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

	public function rateMoves($search) {
		$move = array();

		for ($x = $this->getX() - $this->getSpeed(); $x <= $this->getX() + $this->getSpeed(); $x++) {
			for ($y = $this->getY() - $this->getSpeed(); $y <= $this->y + $this->getSpeed(); $y++) {
				if ($this->getWorld()->validateCoordinates($x, $y) or $this->getWorld()->determineTheObject($x, $y)) {
					continue;
				}

				$score = 0;

				//Суммируем растояние от всех обозримых кошек и выдаем эту сумму за количество баллов (чем больше сумма тем больше расстояние от всех кошек сразу).
				foreach ($search as $object) {
					$distance = abs(sqrt((($x - $object->getX())**2) + (($y - $object->getY())**2)));

					$score += $distance;
				}

				$move[] = array(
						'x' => $x,
						'y' => $y,
						'score' => $score
					);
			}
		}

		return $move;
	}

	abstract public function chooseTheMovement();

	abstract public function move();

	public function KillAnimal() {
		$this->die = true;
	}
}