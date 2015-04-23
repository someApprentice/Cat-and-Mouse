<?php
class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	public $symbol;

	public function __construct(World $world, $x = 0, $y = 0, $view = 1, $speed = 1) {
		$this->view = $view;
		$this->speed = $speed;

		$this->x = $x;
		$this->y = $y;

		$world->addAnimalToMap($this);
	}

	public function getCoordinate() {
		$coordinate['x'] = $this->x;
		$coordinate['y'] = $this->y;

		return $coordinate;
	}

	public function overviewWorld(World $world) {
		$map = $world->getMap();

		$coordinate = $this->getCoordinate();

		foreach($map as $y => $x) {
			foreach($x as $key => $value) {
				if ((($y > $coordinate['y'] - $this->view) and ($y <=  $coordinate['y'] + $this->view)) and ($key > $coordinate['y'] - $this->view) and ($key <=  $coordinate['y'] + $this->view)) {
					$anothermap[$y][$key] = $value;
				}
			}
		}

		return $anothermap;
	}

	public function searchTheAnimal(World $world, Animal $animal) {
		$overview = $this->overviewWorld($world);

		$search = array();

		foreach($overview as $y => $x) {
			foreach($x as $key => $value) {
				if ($value == $animal) {
					$search[$y][$key] = $animal;
				}
			}
		}

		return $search;
	}
}