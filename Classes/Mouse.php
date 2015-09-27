<?php
class Mouse extends Animal {
	public $symbol = "M";

	protected $fears = array("Cat");

	public function move() {
		if ($this->die) {
			//Почему-то здесь код крашиться, если использвовать throw new Exception(" - They Die ~((‡> <br>");
			echo " - They Die ~((‡> <br>";
				
			return false;
		}

		$move = array();

		$overview = $this->world->overviewWorld($this); //Обращение через $this и последующая передача этого же самаого $this. Все ли с этим хорошо?

		$scary = $this->world->searchScaryAnimals($this);

		for ($x = $this->getX() - $this->speed; $x <= $this->getX() + $this->speed; $x++) {
			for ($y = $this->getY() - $this->speed; $y <= $this->y + $this->speed; $y++) {
				$score = 0;

				//Суммируем растояние от всех обозримых кошек и выдаем эту сумму за количество баллов (чем больше сумма тем больше расстояние от всех кошек сразу).
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

		//Выбираем наибольшие значение $score
		usort($move, function($a, $b) {
			    if ($a['score'] == $b['score']) {
			        return 0;
			    }
			    
			    return ($a['score'] > $b['score']) ? -1 : 1;
			}
		);

		$move = array_shift($move); //Ничего страшного если переопределить здесь эту переменную? Массив $move же больше не нужен. 

		$this->world->delimitation($move['x'], $move['y']);

		//И передвигаем мышку
		$this->x = $move['x'];
		$this->y = $move['y'];
	}
}