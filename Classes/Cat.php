<?php
class Cat extends Animal {
	public $symbol = "C";

	public function move(World $world, Mouse $mouse) {
		$from['x'] = $this->x;
		$from['y'] = $this->y;

		$overview = $this->overviewWorld($world);

		$search = $this->searchTheAnimal($world, $mouse);

		$i = 0;

		foreach ($search as $y => $x) {
			if ($i >  0) {
				break;
			} 

			foreach ($x as $key => $value) {
				if ((abs($y - ($from['y'] + $this->speed)) >  abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$this->y -= $this->speed;
					$this->x -= $this->speed;
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) < abs($key - ($from['x'] - $this->speed)))) {
					$this->y += $this->speed;
					$this->x += $this->speed;
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$this->y += $this->speed;
					$this->x -= $this->speed;
				} else if ((abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) and (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed)))) {
					$this->y -= $this->speed;
					$this->x += $this->speed;
				} else if (abs($y - ($from['y'] + $this->speed)) >  abs($y - ($from['y'] - $this->speed))) {
					$this->y -= $this->speed;
				} else if (abs($y - ($from['y'] + $this->speed)) < abs($y - ($from['y'] - $this->speed))) {
					$this->y += $this->speed;
				} else if (abs($key - ($from['x'] + $this->speed)) >  abs($key - ($from['x'] - $this->speed))) {
					$this->x -= $this->speed;
				} else if (abs($key - ($from['x'] + $this->speed)) < abs($key - ($from['x'] - $this->speed))) {
					$this->x += $this->speed;
				}
			}

			$i++;
		}

		if (empty($search)) {
				$negative = $this->speed * (-1);

			$this->x += mt_rand($negative, $this->speed);
			$this->y += mt_rand($negative, $this->speed);
		}

		$to['x'] = $this->x;
		$to['y'] = $this->y;

		$world->moveAnimal($from, $to);
	}	
}