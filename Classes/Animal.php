<?php
class Animal {
	private $x;
	private $y;

	private $overview;

	public function __construct(World $world, $x = 0, $y = 0) {
		$this->x = $x;
		$this->y = $y;

		$this->overviewWorld($world);
	}

	public function getCoordinate() {
		$coordinate['x'] = $this->x;
		$coordinate['y'] = $this->y;

		return $coordinate;
	}

	public function overviewWorld(World $world) {
		$this->overview = $world->getMap();
	}

	public function goUp() {

	}

	public function goDown() {

	}

	public function goRight() {
		$this->x += 1;
	}

	public function goLeft() {
		$this->x += -1;
	}
}