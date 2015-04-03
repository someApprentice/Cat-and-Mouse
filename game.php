<?php
$world = new World();

$mouse = new Mouse($world);
$world->addAnimalToMap($mouse);

$world->moveAnimal($mouse);