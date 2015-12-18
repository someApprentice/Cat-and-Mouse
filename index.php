<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/game.php';
?>

<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <link rel="stylesheet" href="css/style.css">
   </head>
   <body>
      Turn: 0 <br>

      <?php require __DIR__ . '/Templates/print.phtml'; ?>
      <br>

      <?php for ($i = 1; $i <= 10; $i++): ?>
         Turn: <?=$i?> <br>
         
         <?php 
            $world->moveAllAnimals();
         ?>

         <?php require __DIR__ .'/Templates/print.phtml'; ?>

         <br>
      <?php endfor; ?>
           
   </body>
</html>