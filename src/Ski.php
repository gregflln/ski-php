<?php
namespace Core;

class Ski
{
    private $head;
    private $dataset;
    private $template;
    private static $dirconf;

    function __construct()
    {
        if (empty(self::$dirconf)){
          echo '
          <h1 style="
          font-family: sans-serif;
          font-size: xxx-large;
          font-weight: inherit;
          text-align: center;
          ">Welcome To Ski Template Engine 🗻</h1>
          <h3 style="
          text-align: center;
          font-size: x-large;
          letter-spacing: 3px;
          text-transform: uppercase;
          font-family: sans-serif;
          color: #7d7d7d;
          ">Simple PHP Template Engine based on <a href="https://alpinejs.dev/" target="_blank">Alpine.js</a></h3>
          ';
          echo '<p style="font-family:monospace;font-size:large;background:antiquewhite;font-weight: bold;">
          ⚠️Ski root folder missing 🥶 use Ski::SetSkiPath(__DIR__.\'path/to/conf/folder\') before first instance of Ski to specify the root folder for Ski, please use a free folder |
           <a href="https://github.com/gregfn/ski" target="_blank">Check out Ski Documentation</a> 🎿<br></p>';
           return false;
        }
        elseif(!file_exists(self::$dirconf.'/head.php') || !file_exists(self::$dirconf.'/vues') || !file_exists(self::$dirconf.'/components') ){

          echo '
          <h1 style="
          font-family: sans-serif;
          font-size: xxx-large;
          font-weight: inherit;
          text-align: center;
          ">Welcome To Ski Template Engine 🗻</h1>
          <h3 style="
          text-align: center;
          font-size: x-large;
          letter-spacing: 3px;
          text-transform: uppercase;
          font-family: sans-serif;
          color: #7d7d7d;
          ">Simple PHP Template Engine based on <a href="https://alpinejs.dev/" target="_blank">Alpine.js</a></h3>
          ';

          echo '<p style="font-family:monospace;font-size:large;background:antiquewhite;font-weight: bold;">Ski will create necessary files in'.self::$dirconf.'| <a href="github.com/gregfn/ski">Check out Ski Documentation</a> 🎿</p><br>';
          $files_need = ['/vues', '/components','/head.php'];
          foreach ($files_need as $files_need) {
            if(!file_exists(self::$dirconf.$files_need)){
              if ($files_need == '/head.php'){
                touch(self::$dirconf.$files_need);
              }else{
                mkdir(self::$dirconf.$files_need, 0777, true);
              }
              echo '<p style="font-family:monospace;font-size:large;background:antiquewhite;font-weight: bold;">🔥 Ski create a new folder at '.self::$dirconf.$files_need.'</p><br>';
            }
          }
        }else{
          //normal start
          $this->sethead();
        }

    }
    static public function SetSkiPath($path){
      self::$dirconf = $path;
    }
    private function sethead()
    {
        $this->head = file_get_contents(self::$dirconf . "/head.php");
    }
    public function set($dataset)
    {
        //insere les données, json expected
        if(is_array($dataset) OR is_object($dataset)){
          $this->dataset = json_encode($dataset);
        }else{
          $this->dataset = $dataset;
        }
    }
    public function vue($template)
    {
        $template = file_get_contents(
            self::$dirconf . "/vues/" . $template . ".php"
        );

        function insertComponents($template)
        {
            $pattern = "(<@[a-zA-Z]+\b>)";
            $replace = '$0';
            $template = preg_replace_callback(
                $pattern,
                function ($matches) {
                    foreach ($matches as $matches) {
                        $len = strlen($matches);
                        $len = $len - 3;
                        $component = substr($matches, 2, $len);
                        return file_get_contents(
                            Ski::$dirconf .
                                "/components/" .
                                $component .
                                ".php"
                        );
                    }
                },
                $template
            );
            return $template;
        }
        for ($i = 0; $i < 50; $i++) {
            $template = insertComponents($template);
        }
        //reprocess nested component for max deep of 50 iterations

        $this->template = $template;
    }
    public function render()
    {
        $render =
            '<!DOCTYPE html>
    <html lang="en" dir="ltr">
      <head>
        ' .
            $this->head .
            '
      </head>
      <body>
        <div x-data="{datas : init()}">
        ' .
            $this->template .
            '
        </div>

        <script type="text/javascript">
        function init(){
          let datas = ' .
            $this->dataset .
            '
          return datas;
        }
        </script>

      </body>
    </html>';
        print $render;
    }
}
