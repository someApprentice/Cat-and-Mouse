<?php
class Mouse extends Animal {
	public $symbol = "🐁";

	protected $fears = array("Cat");

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
		if ($this->isItDie()) {
			//Почему-то здесь код крашиться, если использвовать throw new Exception(" - They Die ~((‡> <br>");
			echo " - They Die ~((‡> <br>";
		}

		//$overview = $this->world->overviewWorld($this);

		$scary = $this->searchAnimalsAroundByType($this, $this->getFears());

		$move = $this->rateMoves($scary);

		$move = $this->chooseTheMovement($move);

		$this->world->validateCoordinates($move['x'], $move['y']);
		
		$this->x = $move['x'];
		$this->y = $move['y'];

		echo "Mouse move to ({$move['x']}, {$move['y']}). <br>";
	}
}