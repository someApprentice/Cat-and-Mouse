<?php
class Mouse extends Animal {
	public function move(World $world, Cat $cat) {
		$from['x'] = $this->x;
		$from['y'] = $this->y;

		$overview = $this->overviewWorld($world);

		$search = $this->searchTheAnimal($world, $cat);

		foreach($search as $y => $x) {
			foreach ($x as $key => $value) {
				if (abs($y - ($from['y'] + 1)) > abs($y - ($from['y'] - 1))) {
					$this->y += 1;
				} else if (abs($y - ($from['y'] + 1)) < abs($y - ($from['y'] - 1))) {
					$this->y -= 1;
				} else if (abs($x - ($from['x'] + 1)) > abs($x - ($from['x'] - 1))) {
					$this->x += 1;
				} else if (abs($x - ($from['x'] + 1)) < abs($x - ($from['x'] - 1))) {
					$this->x -=1;
				}
			}
		}

		$to['x'] = $this->x;
		$to['y'] = $this->y;

		$world->moveAnimal($from, $to);
	}
}