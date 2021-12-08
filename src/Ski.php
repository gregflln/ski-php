<?php
namespace Core;

use Core\Engine;

class Ski extends Engine
{
    function __construct($skiRootPath)
    {
      Engine::__construct($skiRootPath);
    }

    public function datas($dataset)
    {
        if (is_array($dataset) or is_object($dataset)) {
            $this->dataset = json_encode($dataset);
        } else {
            $this->dataset = $dataset;
        }
    }

    public function template($templateName)
    {
        if (file_exists($this->skiroot . "/templates/" . $templateName . ".php")) {

            $templateContent = file_get_contents($this->skiroot . "/templates/" . $templateName . ".php");
            $this->template = $this->processTemplate($templateContent);

        }else{
          echo $this->msg->alert(
              "Ski not found this template file in " .
                  $this->skiroot .
                  "/templates/" .
                  $templateName .
                  ".php"
          );
          return;
        }
    }

    public function render()
    {
        if ($this->startupVerifs()) {
            try {
                $this->init();
                echo $this->msg->display();
                return $this->rendering();
            } catch (\Exception $e) {
                //echo $this->msg->title();
                echo $this->msg->alert(
                    "Oh no :( Something went wrong..." . $e->getMessage()
                );
            }
        } else {
            //echo $this->msg->title();
            echo $this->msg->alert(
                "[startup verification failed] Oh no :( Ski has encountered an issue at startup, check if you have specified the Ski root folder."
            );
            echo $this->msg->display();
        }
    }
}
