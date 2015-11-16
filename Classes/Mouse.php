<?php
class Mouse extends Animal {
	protected $fears = array("Cat");

	public function getSymbol() {
		return "🐁";
	}

	public function getAllMoves($x, $y) {
		$moves = array();

		$fromX = $x - $this->getSpeed();
		$toX = $x + $this->getSpeed();

		$fromY = $y - $this->getSpeed();
		$toY = $y + $this->getSpeed();

		for ($forX = $fromX; $forX <= $toX; $forX++) {
			for ($forY = $fromY; $forY <= $toY; $forY++) {
				$isInsideMap = $this->getWorld()->isInsideMap($forX, $forY);
				$isOccupied = $this->getWorld()->determineTheObject($forX, $forY);
				$isStraightMove = ($x == $forX || $y == $forY);

				if (!$isInsideMap or $isOccupied or !$isStraightMove) {

					continue;
				}

				$moves[] = array(
					'x' => $forX,
					'y' => $forY
				);
			}
		}

		return $moves;
	}

	public function rateMove($x, $y, $search) {
		$rate = 0;
		$factorOfNearestAnimal = 0;
		$fatorOfCorner = 0;

		$nearestAnimal = $this->foundTheNearestAnimal($search);

		foreach ($search as $object) {
			$distance = max(abs($x - $object->getX()), abs($y - $object->getY()));

			$movesCount = $this->howManyMovesWillDoAnimal($object, $distance); //Нужна ли проверка is_a($object, "Animal")?

			$rate = $movesCount;

			if ($object == $nearestAnimal) {
				$factorOfNearestAnimal = 1.5;
			}
		}

		if (!$this->isItCorner($x, $y)) {
			$fatorOfCorner = 1.5;
		}

		$rate = $rate + ($rate * $factorOfNearestAnimal) + ($rate * $fatorOfCorner);

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
			throw new Exception(" - They Die ~((‡> <br>");
		}

		//$overview = $this->world->overviewWorld($this);

		$moves = $this->getAllMoves($this->getX(), $this->getY());

		$scary = $this->getWorld()->searchAnimalsAroundByType($this, $this->getFears());

		$ratedMoves = $this->rateMoves($moves, $scary);

		$move = $this->chooseTheMovement($ratedMoves);
		
		$this->x = $move['x'];
		$this->y = $move['y'];
	}
}