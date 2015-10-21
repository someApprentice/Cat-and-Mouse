<?php
class Cat extends Animal {
	public $symbol = "🐈";

	protected $tracks = array("Mouse");

	public function getSymbol() {
		return $this->symbol;
	}

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

			$rate = 1 / $rate;
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
		$moves = $this->getAllMoves();

		$track = $this->searchAnimalsAroundByType($this, $this->getTracks());

		$ratedMoves = $this->rateMoves($moves, $track);

		$move = $this->chooseTheMovement($ratedMoves);

		$this->world->isInsideMap($move['x'], $move['y']);

		$this->x = $move['x'];
		$this->y = $move['y'];

		return $move;
	}	
}