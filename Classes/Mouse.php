<?php
class Mouse extends Animal {
	public $symbol = "🐁";

	protected $fears = array("Cat");

	public function getAllMoves() {
		$moves = array();

		$fromX = $this->getX() - $this->getSpeed();
		$toX = $this->getX() + $this->getSpeed();

		$fromY = $this->getY() - $this->getSpeed();
		$toY = $this->getY() + $this->getSpeed();

		for ($x = $fromX; $x <= $toX; $x++) {
			for ($y = $fromY; $y <= $toY; $y++) {
				if ($this->getWorld()->isInsideMap($x, $y) or $this->getWorld()->determineTheObject($x, $y)) {
					continue;
				}

				if (($x > $this->getX() and $y > $this->getY()) or ($x > $this->getX() and $y < $this->getY()) or ($x < $this->getX() and $y > $this->getY()) or ($x < $this->getX() and $y < $this->getY())) {
					continue;
				}

				$moves[] = array(
					'x' => $x,
					'y' => $y
				);
			}
		}

		return $moves;
	}

	public function rateMove($x, $y, $search) {
		$rate = 0;

		foreach ($search as $object) {
			$distance = abs(sqrt((($x - $object->getX())**2) + (($y - $object->getY())**2)));

			$rate += $distance;
		}

		return $rate;
	}

	public function rateMoves($moves, $search) {
		$ratedMoves = array();

		foreach ($moves as $move) {
			$x = $move['x'];
			$y = $move['y'];

			$rate = $this->rateMove($move['x'], $move['y'], $search);

			$ratedMoves[] = array(
				'x' => $x,
				'y' => $y,
				'score' => $rate
			);
		}


		return $ratedMoves;
	}


	public function move() {
		if ($this->isItDie()) {
			//Почему-то здесь код крашиться, если использвовать throw new Exception(" - They Die ~((‡> <br>");
			echo " - They Die ~((‡> <br>";
		}

		//$overview = $this->world->overviewWorld($this);

		$moves = $this->getAllMoves();

		$scary = $this->searchAnimalsAroundByType($this, $this->getFears());

		$ratedMoves = $this->rateMoves($moves, $scary);

		$move = $this->chooseTheMovement($ratedMoves);

		$this->world->isInsideMap($move['x'], $move['y']);
		
		$this->x = $move['x'];
		$this->y = $move['y'];

		return $move;
	}
}