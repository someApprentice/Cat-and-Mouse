<?php
$world = new World();

$mouse = new Mouse($world, 3, 5, 5);
$cat = new Cat ($world, 2, 7, 7);

$search = $mouse->searchTheAnimal($world, $cat);
$mouse->move($world, $cat);

$world->printMap();
