<?php
$world = new World();

$mouse = new Mouse(5, 5, 4, 1);
$cat = new Cat(7, 7, 3, 2);

$world->addAnimal($mouse);
$world->addAnimal($cat);

