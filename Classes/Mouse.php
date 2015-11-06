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
				if ($this->getWorld()->isInsideMap($forX, $forY) or $this->getWorld()->determineTheObject($forX, $forY)) {

					continue;
				}

				if (($forX > $x and $forY > $y) or ($forX > $x and $forY < $y) or ($forX < $x and $forY > $y) or ($forX < $x and $forY < $y)) {
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

		$nearestAnimal = $this->foundTheNearestAnimal($search);

		foreach ($search as $object) {
			$distance = max(abs($x - $object->getX()), abs($y - $object->getY()));

			$movesCount = $this->howManyMovesWillDoAnimal($object, $distance); //Нужна ли проверка is_a($object, "Animal")?

			$preRate = $movesCount;

			if ($object == $nearestAnimal) {
				$preRate = $preRate * 1.5;
			}

			$rate += $preRate;
		}

		if (!$this->isItCorner($x, $y)) {
			$rate = $rate * 1.5;
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
			throw new Exception(" - They Die ~((‡> <br>");
		}

		//$overview = $this->world->overviewWorld($this);

		$moves = $this->getAllMoves($this->getX(), $this->getY());

		$scary = $this->searchAnimalsAroundByType($this, $this->getFears());

		$ratedMoves = $this->rateMoves($moves, $scary);

		$move = $this->chooseTheMovement($ratedMoves);

		$this->world->isInsideMap($move['x'], $move['y']);
		
		$this->x = $move['x'];
		$this->y = $move['y'];

		return $move;
	}
}