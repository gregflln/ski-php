<?php

namespace Core;

/**
 *
 */
class Messages
{
  private int $title_call=0;
  function __construct()
  {

  }
  private function title(){
    return '
    <h1 style="
    font-family: sans-serif;
    font-size: xxx-large;
    font-weight: inherit;
    text-align: center;
    ">Welcome To Ski Template Engine 🗻<sup style="font-size:large">alpha</sup></h1>
    <h3 style="
    text-align: center;
    font-size: x-large;
    letter-spacing: 3px;
    text-transform: uppercase;
    font-family: sans-serif;
    color: #7d7d7d;
    ">Simple PHP Template Engine based on <a href="https://alpinejs.dev/" target="_blank">Alpine.js</a></h3>
    ';
  }
  public function alert($message){
    if($this->title_call == 0){
      echo $this->title();
      $this->title_call++;
    }
    return '<p style="display:block;border: 2px solid rgba(0,0,0,.1);border-radius: 4px;padding:10px;font-family:monospace;font-size:large;background:antiquewhite;font-weight: bold;"> ⚠️⚠️'.$message.'| <a href="https://github.com/gregfn/ski">Check out Ski Documentation</a> 🎿</p>';
  }
}

 ?>
