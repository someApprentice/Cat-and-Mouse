<?php
class Cat extends Animal {
	public $symbol = "🐈";

	protected $tracks = array("Mouse");

	public function chooseTheMovement($move) {
		usort($move, function($a, $b) {
			    if ($a['score'] == $b['score']) {
			        return 0;
			    }
			    
			    return ($a['score'] > $b['score']) ? -1 : 1;
			}
		);

		$move = array_shift($move);

		return $move;
	}

	public function move() {
		$overview = $this->world->overviewWorld($this);

		$track = $this->world->searchAnimalsAroundByType($this, $this->getTracks());

		$move = $this->rateMoves($track);

		$move = $this->chooseTheMovement($move);

		$this->world->delimitation($move['x'], $move['y']);

		$this->x = $move['x'];
		$this->y = $move['y'];
	}	
}