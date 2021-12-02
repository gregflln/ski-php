<?php 
//$this->msg = new Messages;
//$this->sethead();
/*
if (empty($this->skiroot)){
    $this->msg->noRootDir();
   return false;
}
elseif(!file_exists($this->skiroot.'/head.php') || !file_exists($this->skiroot.'/vues') || !file_exists($this->skiroot.'/components') ){

  $this->msg->title();
  $this->msg->alert('🗻Ski will create necessary files in '.$this->skiroot.' ! 🔥🔥🔥');

  $files_need = ['/vues', '/components','/head.php'];
  foreach ($files_need as $files_need) {
    if(!file_exists($this->skiroot.$files_need)){
      if ($files_need == '/head.php'){
        touch($this->skiroot.$files_need);
        file_put_contents($this->skiroot.$files_need,
        '<meta charset=\'utf-8\'>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>'
      );
      }else{
        mkdir($this->skiroot.$files_need, 0777, true);
      }
      $this->msg->alert('✔️ New file or folder at '.$this->skiroot.$files_need);
    }
  }
}else{
  //normal start
  $this->sethead();
}
*/
