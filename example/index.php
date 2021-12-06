<?php

require '../vendor/autoload.php';

use \Core\Ski;

$ski = new Ski(__DIR__.'/ski');

$datas = [
  'data'=>[
    'posts'=> [
      ['username' => 'richard', 'content'=>'lorem ipsum dolor sit amet'],
      ['username' => 'Albert88', 'content'=>'lorem ipsum dolor sit amet'],
      ['username' => 'begonie75', 'content'=>'lorem ipsum dolor sit amet'],
      ['username' => 'xxslap', 'content'=>'lorem ipsum dolor sit amet'],
      ['username' => 'lapindu38', 'content'=>'lorem ipsum dolor sit amet'],
      ['username' => 'emily_qsjvnqk', 'content'=>'lorem ipsum dolor sit amet']
    ]
  ]
];

$ski->datas($datas);
$ski->template('template');

$ski->render();
 ?>
