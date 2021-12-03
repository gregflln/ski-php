<?php

require '../vendor/autoload.php';

use \Core\Ski;

$ski = new Ski(__DIR__.'/ski');

$datas = [
  'data'=>[
    'data'=> 'hello'
  ]
];

$ski->datas($datas);
$ski->template('template');
$ski->layout('layout');

$ski->render();
 ?>
