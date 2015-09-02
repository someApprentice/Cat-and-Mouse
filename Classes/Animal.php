<?php
class Animal {
	protected $x;
	protected $y;

	protected $view;
	protected $speed;

	protected $fears = array();
	protected $hunted = array();

	protected $die;

	public $symbol;

	protected $world;

	public function __construct($x = 0, $y = 0, $view = 1, $speed = 1) {
		$this->view = $view;
		$this->speed = $speed;

		$this->x = $x;
		$this->y = $y;

		$this->die = false;
	}

	public function realizingTheWorld($world) {
		$this->world = $world;
	}

	public function getCoordinate() {
		$coordinate['x'] = $this->x;
		$coordinate['y'] = $this->y;

		return $coordinate;
	}

	public function overviewWorld() {
		$map = $this->world->getMap();

		$coordinate = $this->getCoordinate();

		foreach($map as $x => $y) {
			foreach($y as $key => $value) {
				if ((($x >= $coordinate['x'] - $this->view) and ($x <=  $coordinate['x'] + $this->view)) and ($key >= $coordinate['y'] - $this->view) and ($key <=  $coordinate['y'] + $this->view)) {
					$overview[$x][$key] = $value;
				}
			}
		}

		return $overview;
	}

	public function searchScaryAnimals() {
		$overview = $this->overviewWorld();

		$search = array();

		foreach($overview as $x => $y) {
			foreach($y as $key => $value) {

				if (is_object($value)) {
					foreach ($this->fears as $fear) {
						if (get_class($value) == $fear) {
							$search[$x][$key] = $value;
						}
					}	
				}
			
			}
		}

		return $search;
	}

	public function searchTrackedAnimals() {
		$overview = $this->overviewWorld();

		$search = array();
		
		foreach($overview as $x => $y) {
			foreach($y as $key => $value) {

				if (is_object($value)) {
					foreach ($this->hunted as $hunt) {
						if (get_class($value) == $hunt) {
							$search[$x][$key] = $value;
						}
					}	
				}

			}
		}

		return $search;
	}

	public function KillAnimal() {
		$this->die = true;
	}
}