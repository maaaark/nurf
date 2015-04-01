<?php

class CHECK_MODULE {
   private $system_name;
   private $status;
   
   public function __construct($name){
      $this->system_name = trim(strtolower($name));
      
      $this->status = false;
      if(file_exists("modules/".$this->system_name."/init.php")){
         $this->status = true;
      }
   }
   
   public function check(){
      return $this->status;
   }
   
   public function get_init(){
      if($this->status){
         return "modules/".$this->system_name."/init.php";
      }
      return false;
   }
}

?>