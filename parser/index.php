<?php
require_once 'system/init.php';
require_once 'system/tmpl_main.class.php';

if(isset($_SESSION["user_id"]) && isset($_SESSION["admin_rights"])){
   if(isset($_GET["parser"])){
      if(file_exists("parser/".trim($_GET["parser"])."/init.php")){
         define("CURRENT_MODULE", trim($_GET["parser"]));
         require_once "parser/".trim($_GET["parser"])."/init.php";
      } else {
         $template = new template;
         $template->load("404_error");
         $tmpl = $template->display(true);
         $tmpl = $template->operators();
         echo $tmpl;
      }
   } else {
      $template = new template;
      $template->load("index");
      $tmpl = $template->display(true);
      $tmpl = $template->operators();
      echo $tmpl;
   }
} else {
   $template = new template;
   $template->load("login");
   $template->assign("SITE_TITLE", "Login");
   $tmpl = $template->display();
   $tmpl = $template->operators();
   echo $tmpl;
}

?>