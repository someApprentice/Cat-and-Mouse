<?php
class Cat extends Animal {

	protected $tracks = array("Mouse");

	public function getSymbol() {
		return "🐈";
	}

	public function getAllMoves($x, $y) {
		$moves = array();

		$fromX = $x - $this->getSpeed();
		$toX = $x + $this->getSpeed();

		$fromY = $y - $this->getSpeed();
		$toY = $y + $this->getSpeed();

		for ($forX = $fromX; $forX <= $toX; $forX++) {
			for ($forY = $fromY; $forY <= $toY; $forY++) {
				if ($this->getWorld()->isInsideMap($forX, $forY) or $this->isItNotOneOfTrack($forX, $forY, $this->getTracks())) {
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
		
		foreach ($search as $object) {
			$distance = max(abs($x - $object->getX()), abs($y - $object->getY()));

			$movesCount = $this->howManyMovesWillDoAnimal($this, $distance);

			$rate += $movesCount;

			if ($rate == 0) {
				$rate = 99999;
			} else {
				$rate = 1 / $rate;
			}
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
		//$overview = $this->world->overviewWorld($this);
		$moves = $this->getAllMoves($this->getX(), $this->getY());

		$track = $this->searchAnimalsAroundByType($this, $this->getTracks());

		$ratedMoves = $this->rateMoves($moves, $track);

		$move = $this->chooseTheMovement($ratedMoves);

		$this->world->isInsideMap($move['x'], $move['y']);

		$animal = $this->getWorld()->determineTheObject($move['x'], $move['y']);

		if ($animal) {
			$animal->KillTheAnimal();
		}

		$this->x = $move['x'];
		$this->y = $move['y'];

		return $move;
	}	
}