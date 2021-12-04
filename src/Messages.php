<?php

namespace Core;

/**
 *
 */
class Messages
{
  private int $title_call=0;
  private $errors;
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
display: block;
background: #3b75a7;
color: #fff;
margin:0;
padding: 38px 0;
    ">Ski Template Engine 🗻<sup style="font-size:large">alpha</sup>
    <br>
    <a href="https://github.com/gregfn/ski" target="_blank" style="font-size: x-large;
color: #fff;
margin-top: 19px;
display: block;">Check out documentation</a></h1>
    ';
  }
  public function alert($message){

    if (!is_array($this->errors)){
      $this->errors = [];
    }
    if(in_array($message, $this->errors)){
      return;
    }else{
      $this->errors[] = $message;
    }
  }
  public function display(){

    //var_dump($this->errors);
    $response = $this->title();
    if(empty($this->errors)){
      return;
    }
    foreach ($this->errors as $error) {
      $response .= '<p style="display:block;margin:0;font-family: sans-serif;padding:10px;font-size:large;background:#326591;color:#fff;border-bottom: 3px solid rgba(0,0,0,.12);"> ⚠️⚠️'.$error.'</p>';
    }
    return $response;
  }
}

 ?>
