<?php

class URL_PARSER {
   private $org_page;
   private $url_arr;
   
   public function __construct($page){
      $this->org_page = $page;
      $this->url_arr  = explode("/", $page);
   }
   
   public function get_arr(){
      return $this->url_arr;
   }
   
   public function get_arr_element($i){
      if(isset($this->url_arr[$i])){
         return $this->url_arr[$i];
      }
      return false;
   }
   
   public function check_page(){
      if(isset($this->url_arr[0])){
         if(file_exists("templates/pages/".trim(strtolower($this->url_arr[0])).".tpl")){
            return "pages/".trim(strtolower($this->url_arr[0]));
         }
      }
      return false;
   }
}

?>