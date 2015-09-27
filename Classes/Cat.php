<?php
class Cat extends Animal {
	public $symbol = "C";

	protected $hunted = array("Mouse");

	public function move() {
		$move = array();

		$overview = $this->world->overviewWorld($this);

		$track = $this->world->searchTrackedAnimals($this);

		for ($x = $this->getX() - $this->speed; $x <= $this->getX() + $this->speed; $x++) {
			for ($y = $this->getY() - $this->speed; $y <= $this->y + $this->speed; $y++) {
				$score = 0;

				foreach ($scary as $object) {
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

		//Выбираем наименьшее значение $score
		usort($move, function($a, $b) {
			    if ($a['score'] == $b['score']) {
			        return 0;
			    }
			    
			    return ($a['score'] > $b['score']) ? -1 : 1;
			}
		);

		$move = array_shift($move); 

		$this->world->delimitation($move['x'], $move['y']);

		$this->x = $move['x'];
		$this->y = $move['y'];
	}	
}