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

	public function rateMove($x, $y) {
		$rate = 0;
		$factorOfNearestAnimal = 0;
		$factorOfCorner = 0;

		$search = $this->getWorld()->searchAnimalsAroundByType($this, $this->getFears());

		$nearestAnimal = $this->foundTheNearestAnimal($search);

		foreach ($search as $object) {
			$distance = max(abs($x - $object->getX()), abs($y - $object->getY()));

			$movesCount = $this->howManyMovesWillDoAnimal($object, $distance);

			$rate += $movesCount;

			//За расстояние от ближайщего животного дается больше балов
			if ($object === $nearestAnimal) {
				$factorOfNearestAnimal = 0.5;

				$rateOfNearestAnimal = $movesCount * $factorOfNearestAnimal;
			}
		}

		if (!$this->isItCorner($x, $y)) {
			$factorOfCorner = 0.5;
		}

		$rate = $rate + ($rateOfNearestAnimal) + ($rate * $factorOfCorner);

		return $rate;
	}

	public function move() {
		if ($this->isItDie()) {
			throw new Exception(" - They Die ~((‡> <br>");
		}

		//$overview = $this->world->overviewWorld($this);

		$moves = $this->getAllMoves($this->getX(), $this->getY());

		$ratedMoves = $this->rateMoves($moves);

		$move = $this->chooseTheMovement($ratedMoves);
		
		$this->x = $move['x'];
		$this->y = $move['y'];
	}
}