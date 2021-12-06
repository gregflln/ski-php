<?php
namespace Core;

 /**
  *
  */
 class Engine extends XTag
 {
   protected $head;
   protected $dataset;
   protected $template;
   protected $msg;
   protected $skiroot;
   protected bool $xss_protection = true;

   function __construct($skiRootPath)
   {

     $this->msg = new Messages;
     $this->skiroot = $skiRootPath;

   }
   protected function init()
   {
       $this->head = file_get_contents($this->skiroot . "/head.php");

       if ($this->xss_protection == true && !empty($this->dataset))
       {
           $this->dataset = htmlentities($this->dataset, ENT_SUBSTITUTE, 'UTF-8');
       }

       if (!empty($this->layout)){
         $this->addTemplateToLayout();
       }

   }
   protected function startupVerifs()
   {
       if (empty($this->skiroot))
       {
           $this->msg->alert('Ski root folder missing 🥶 Specify path in Ski constructeur');
           return false;

       }elseif(!file_exists($this->skiroot . '/head.php'))
       {
         $this->msg->alert('Ski can\'t start 🥶 Missing "head.php" file');
         return false;
       }
       elseif (!file_exists($this->skiroot . '/templates'))
       {
           $this->msg->alert('Ski can\'t start 🥶 Missing templates folder');
           return false;
       }
       else
       {
           return true;
       }
   }
   /// Go to SkiElements Class

   //---------
   protected function processTemplate($template)
   {

      for ($i = 0; $i < 100; $i++) {
            $templateprocessed = $this->processTag($template);

          if ($templateprocessed === false) {
              break;
          } elseif ($i == 99) {
              echo $this->msg->alert('it\'s over 9000 ! Maybe you have cross-referencing or self-referencing components 🧩');
          } else {
              $template = $templateprocessed;
          }
      }
      return $template;
   }

   protected function rendering()
   {
       $render =
    '<!DOCTYPE html>
    <html>
    <head>
    '
    .$this->head.
    '
    </head>
    <body x-data="{datas : SkiInit()}">
    '
    .$this->template.
    '
    <script type="text/javascript">
      function SkiInit(){
      let datas = '
      .$this->dataset.';
      return datas;
      }
    </script>
    </body>
    </html>';
    $render = eval("?>$render");
    echo $render;
   }
 }
