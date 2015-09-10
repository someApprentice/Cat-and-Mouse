<?php
class Cat extends Animal {
	public $symbol = "C";

	protected $hunted = array("Mouse");

	public function move() {
		echo "Cat on ({$this->x}, {$this->y})";

		$from['x'] = $this->x;
		$from['y'] = $this->y;

		$to['x'] = '';
		$to['y'] = '';

		$overview = $this->overviewWorld();

		$search = $this->searchTrackedAnimals();

		if (empty($search)) {
			$see = 'No';
		} else {
			$see = 'Yes';
		} 

		$i = 0;

		foreach ($search as $y => $x) {
			if ($i > 1) {
				break;

				$search = '';
			} 

			foreach ($x as $key => $value) {
				//Очень не красивое условие (находится наиболее близкая координата к первой попавшейся мышки из массива $search). Возможно ли это исправить?
				if ((abs($y - ($from['y'] + $this->speed)) > abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$to['y'] = $this->y - $this->speed;
					$to['x'] = $this->x - $this->speed;

					echo " 1 "; 
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) < abs($key - ($from['x'] - $this->speed)))) {
					$to['y'] = $this->y + $this->speed;
					$to['x'] = $this->x + $this->speed;

					echo " 2 "; 
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$to['y'] = $this->y + $this->speed;
					$to['x'] = $this->x - $this->speed;

					echo " 3 "; 
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$to['y'] = $this->y - $this->speed;
					$to['x'] = $this->x + $this->speed;

					echo " 4 "; 
				} else if (abs($y - ($from['y'] + $this->speed)) > abs($y - ($from['y'] - $this->speed))) {
					$to['y'] = $this->y - $this->speed;
					$to['x'] = $this->x;

					echo " 5 "; 
				} else if (abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) {
					$to['y'] = $this->y + $this->speed;
					$to['x'] = $this->x;

					echo " 6 "; 
				} else if (abs($key - ($from['x'] + $this->speed)) > abs($key - ($from['x'] - $this->speed))) {
					$to['y'] = $this->y;
					$to['x'] = $this->x - $this->speed;

					echo " 7 "; 
				} else if (abs($key - ($from['x'] + $this->speed)) < abs($key - ($from['x'] - $this->speed))) {
					$to['y'] = $this->y;
					$to['x'] = $this->x + $this->speed;

					echo " 8 "; 
				}
			}

			$i++;
		}

		if (empty($search)) {
			$negative = $this->speed * (-1);

			$to['x'] = $this->x + mt_rand($negative, $this->speed);
			$to['y'] = $this->y + mt_rand($negative, $this->speed);

			echo " 0 ";
		}
	
		$to = $this->world->delimitation($from, $to);

		$this->x = $to['x'];
		$this->y = $to['y'];

		echo " to ({$this->x}, {$this->y}) {$see} <br>";
		
		$this->world->moveAnimal($from, $to);
	}	
}