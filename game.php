<?php
$world = new World();

$mouse = new Mouse(5, 7, 4, 1);
$cat = new Cat(7, 7, 3, 2);
$tom = new Cat(4, 4, 3, 2);


$world->addAnimal($mouse);
$world->addAnimal($cat);
$world->addAnimal($tom);