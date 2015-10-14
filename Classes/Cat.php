<?php
class Cat extends Animal {
	public $symbol = "🐈";

	protected $tracks = array("Mouse");

	public function getAllMoves() {
		$moves = array();

		for ($x = $this->getX() - $this->getSpeed(); $x <= $this->getX() + $this->getSpeed(); $x++) {
			for ($y = $this->getY() - $this->getSpeed(); $y <= $this->y + $this->getSpeed(); $y++) {
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

	public function rateMoves($moves, $search) {
		$ratedMoves = array();

		foreach ($moves as $move) {
			$x = $move['x'];
			$y = $move['y'];

			$score = 0;

			//Допилить эту функцию чтобы у хода к ближайщей мышке было болшее балов. Как?
			foreach ($search as $object) {
				$distance = abs(sqrt((($x - $object->getX())**2) + (($y - $object->getY())**2)));

				$score += $distance;

				$score = 1 / $score;
			}

			$ratedMoves[] = array(
				'x' => $x,
				'y' => $y,
				'score' => $score
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