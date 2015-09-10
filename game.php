<?php
$world = new World();

$mouse = new Mouse(5, 5, 4, 1);
$cat = new Cat(7, 7, 3, 2);

$world->addAnimal($mouse);
$world->addAnimal($cat);

echo "Turn: 0 <br>";
$world->printMap();
echo "<br>";

for ($i = 1; $i < 10; $i++) {
	echo "Turn: " . $i . "<br>";

	$mouse->move();
	$cat->move();

	$world->printMap();
	echo "<br>";
}
