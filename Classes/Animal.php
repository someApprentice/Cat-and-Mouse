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

	public function returnWorldToTheAnimal($world) {
		$this->world = $world;
	}

	public function getCoordinate() {
		$coordinate['x'] = $this->x;
		$coordinate['y'] = $this->y;

		return $coordinate;
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}

	//getWorld() {return $this->world} нужно ли? 

	public function KillAnimal() {
		$this->die = true;
	}
}