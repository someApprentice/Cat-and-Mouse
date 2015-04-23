<?php
$world = new World();

$mouse = new Mouse($world, 5, 5, 4, 1);
$cat = new Cat ($world, 7, 7, 1, 2);

for ($i = 0; $i < 10; $i++) {
	$mouse->move($world, $cat);
	$cat->move($world, $mouse);

	echo "Turn: " . $i . "\n";
	$world->printMap();
	echo "\n";
}
