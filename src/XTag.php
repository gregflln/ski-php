<?php
namespace Core;

/**
 *
 */
class XTag
{

  private function processOnce($template,$tagName){

    $tag = $this->getNameOfTag($tagName);
    $pattern = "(<x-[a-zA-Z]+>)";
    $replace = '$0';
    $replacements = null;
    $template = preg_replace_callback(
      $pattern,
      function ($matches) use ($tag) {
          foreach ($matches as $match) {
              if (
                  !file_exists(
                      $this->skiroot . "/components/" . $tag . ".php"
                  )
              ) {
                  echo $this->msg->alert(
                      'Component: "@' . $tag . '" not found 🧩'
                  );
                  return;
              }
              $content = file_get_contents(
                  $this->skiroot . "/components/" . $tag . ".php"
              );
              $content = '<x-'.$tag.'>'.$content.'</x-'.$tag.'>';
              return $content;
          }
      },
      $template,
      1,
      $replacements
    );
    if ($replacements == 0) {
      return false;
    } else {
      return $template;
    }
  }
  /*
  Tag processing algorithm
  */
  private function getNameOfTag($tag){
    $len = strlen($tag);
    $len = $len - 4;
    $tag = substr($tag, 3, $len);
    return $tag;
  }

  private function searchTag($template){
    $tags = [];
    if(preg_match('/(<x-(?!slot)[a-zA-Z]+ ?(.+>|[>]))/', $template, $tags) !== 0){
      $tag = $tags[0];

      return $tag;

    }else{
      return false;
    }
  }
  private function getAttributes($tagName){
    $match = [];
    //$tag = $this->getNameOfTag($tagName);
    //var_dump($tag);
    $attributes = preg_match('/<x-[a-zA-Z]+!| ( ?(.+)(?=>))/i', $tagName, $match);
    //var_dump($match);
    if (empty($match[0])){
      return null;
    }else{
      return $match[0];
    }
  }
  private function stripAttributes($template,$tagName){

    $tag = $this->getNameOfTag($tagName);

    $replacement = '';
    $count = 0;

    $template = preg_replace('/(?<=<x-'.$tag.')( ?(.+)(?=>))/i', $replacement, $template, 1 ,$count);

    return $template;

  }
  private function stripAttributesFromTag($tagName){

    $tagName = preg_replace('/<x-[a-zA-Z]+!| ( ?(.+)(?=>))/i', '', $tagName);
    return $tagName;

  }
  private function insertAttributes($template, $tagName, $attributes){
    //call it after neutralisation
    $count = 0;
    $tag = $this->getNameOfTag($tagName);
    $searchTag = '<ski-'.$tag.'>';
    $tagWithAttributes = '<ski-'.$tag.' '.$attributes.'>';

    //$template = str_replace($searchTag, $tagWithAttributes,$template, $count);
    $pos = strpos($template, $searchTag);
      if ($pos !== false) {
        $template = substr_replace($template, $tagWithAttributes, $pos, strlen($searchTag));
    }

    return $template;
  }
  //
  private function searchEncloseTag($template, $TagName){
    $encTags = [];

    $TagName = $this->getNameOfTag($TagName);


    if(preg_match_all('(<\/x-(?!slot)[x\-'.$TagName.']+>)', $template, $encTags) !== 0){
      return $encTags[0];
    }else{
      return false;
    }
  }
  private function getTagContent($template, $tagName){
    $content = '';

    $tagName = $this->getNameOfTag($tagName);


    preg_match('/(?<=<x-'.$tagName.'>)(.*?)(?=<\/x-'.$tagName.'>)/ms', $template, $content);



    if(!empty($content[0]) !== false){

      $content = $content[0];

    }else{
      $content = '';
    }

    return $content;

  }
  private function cleanBetweenTag($template, $tagName)
  {
    $match = '';

    $tagName = $this->getNameOfTag($tagName);

    $anti_collision_marker = '<xxx-Av0idColl1s1oN-here-xxx_KaamelottCSympa>'; //WTF string prevent replacement of already exist tag

    return preg_replace('/(?<=<x-'.$tagName.'>)(.*?)(?=<\/x-'.$tagName.'>)/ms', $anti_collision_marker, $template);
  }
  private function insertComponent($template, $tagName)
  {

    $anti_collision_marker = '<xxx-Av0idColl1s1oN-here-xxx_KaamelottCSympa>';

    $filename = $this->getNameOfTag($tagName);
    $component = file_get_contents($this->skiroot.'/components/'.$filename.'.php');

    $template = str_replace($anti_collision_marker, $component, $template);

    return $template;
  }
  private function insertSlot($template, $content = null){
    if (empty($content)){
      return $template;
    }
    $template = str_replace('<x-slot></x-slot>', $content, $template, $count);
    return $template;

  }
  private function neutralizeTag($template, $tagName){
    $tag = $this->getNameOfTag($tagName);
    $template = str_replace('<x-'.$tag.'>', '<ski-'.$tag.'>', $template);
    $template = str_replace('</x-'.$tag.'>', '</ski-'.$tag.'>', $template);
    return $template;
  }
  /*
  ProcessTag fonction process the first component tag that found in template

  return $template: String with injected component

  return false: Bool if no tag was found in $template

  False return terminates processTemplate() function in Core\Engine::class
  */
  protected function processTag($template){
    /*
    searchTag search if template contain an <x-tag>
    return $tagName: string "<x-tag>"
    Else return false
    */
    $tagName = $this->searchTag($template);

    if($tagName !== false){

      /*
      put HTML attributes in $attributes
      */
      $attributes = $this->getAttributes($tagName);

      /*
      Delete all HTML attributes in return <x-tag>
      */
      $tagName = $this->stripAttributesFromTag($tagName);

      /*
      Search Enclosing Tag in $template, if not found, the tag will be process as an self enclosing tag
      */
      $searchEncTag = $this->searchEncloseTag($template,$tagName);


      /*
       Process tag in format <x-tag></x-tag>
      */
      if ($searchEncTag !== false){

        //delete HTML attribute from Tag in $template
        $template = $this->stripAttributes($template, $tagName);

        //Get content between Tag and store it in $content, for the next processing iteration
        $content = $this->getTagContent($template, $tagName);

        //Remove All between <x-tag> and </x-tag>
        $template = $this->cleanBetweenTag($template, $tagName);

        //Set content of tag.php file between <x-tags>
        $template = $this->insertComponent($template, $tagName);

        //Replace <x-slot></x-slot> by $content
        $template = $this->insertSlot($template, $content);

        //neutralizeTag transform <x-tag> in <ski-tag>, for the next iteration, it will be ignored
        $template = $this->neutralizeTag($template, $tagName);

        // Insert HTML attributes store in $attributes in tag
        $template = $this->insertAttributes($template, $tagName,$attributes);

        return $template;

      }else{
        /*
         Process tag in format <x-tag>
        */
        $template = $this->stripAttributes($template, $tagName);
        $template = $this->processOnce($template,$tagName);
        $template = $this->insertSlot($template);
        $template = $this->neutralizeTag($template,$tagName);
        $template = $this->insertAttributes($template, $tagName,$attributes);

        return $template;
      }

    }else{
      return false;
    }
  }
}
