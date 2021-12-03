<?php
namespace Core;
 /**
  *
  */
 class Engine
 {
   protected $head;
   protected $dataset;
   protected $template;
   protected $layout;
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
           $this->msg->alert('Ski root folder missing 🥶 use Ski::SetSkiPath(__DIR__.\'path/to/conf/folder\') before first instance of Ski to specify the root folder for Ski, please use a free folder');
           return false;

       }
       elseif (!file_exists($this->skiroot . '/head.php') || !file_exists($this->skiroot . '/templates') || !file_exists($this->skiroot . '/components'))
       {
           return false;
       }
       else
       {
           return true;
       }
   }
   private function processOnce($template){
     $pattern = "(<@(?!template)[a-zA-Z]+>)";
     $replace = '$0';
     $replacements = null;
     $template = preg_replace_callback(
       $pattern,
       function ($matches) {
           foreach ($matches as $match) {
                if ($match == '<@template>'){
                  return '<@template>';
                  continue; //ignore @template, tag reserved for layouts only
                }
               $len = strlen($match);
               $len = $len - 3;
               $component = substr($match, 2, $len);
               if (
                   !file_exists(
                       $this->skiroot . "/components/" . $component . ".php"
                   )
               ) {
                   echo $this->msg->alert(
                       'Component: "@' . $component . '" not found 🧩'
                   );
                   return;
               }
               $content = file_get_contents(
                   $this->skiroot . "/components/" . $component . ".php"
               );
               return $content;
           }
       },
       $template,
       -1,
       $replacements
     );
     if ($replacements == 0) {
       return false;
     } else {
       return $template;
     }
   }
   protected function processTemplate($template)
   {
      for ($i = 0; $i < 1000; $i++) {
          $templateprocessed = $this->processOnce($template);

          if ($templateprocessed === false) {
              break;
          } elseif ($i == 999) {
              echo $this->msg->alert(
                  'it\'s over 9000 (exactly 999 iterations of processing) ! Maybe you have cross-referencing or self-referencing components 🧩'
              );
          } else {
              $template = $templateprocessed;
          }
      }
      return $template;
   }
   protected function addTemplateToLayout(){
     $template = $this->template;
     $layout = $this->layout;
     $processed = preg_replace("(<@template>)",$template,$layout);
     $this->template = $processed;
   }
   protected function rendering()
   {
       $render =
    '
    <!DOCTYPE html>
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
