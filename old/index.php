<?php

/******************************************
 ******************************************
 **        Copyright (C) 2015            **
 **               by                     **
 **       heyitsmark & torrnext          **
 ******************************************
 ******************************************/

require_once 'system/config.php';
require_once 'system/init.php';
require_once 'system/tmpl_main.class.php';

if(isset($_GET["page"])&&trim($_GET["page"])!=""){
   $url_parser = new URL_PARSER($_GET["page"]);
   $page       = $url_parser->get_arr_element(0);
   $url_arr    = $url_parser->get_arr();
} else {
   $page       = false;
}

if($page == null || $page == false || $page == "index"){
   // Startseite anzeigen
   $template = new Template();
   $template->load("index");
   $template->assign("SITE_TITLE", "Startseite");
   $tmpl = $template->display(true);
   $tmpl = $template->operators();
   echo $tmpl;
} else {
   // Handelt es sich um einen Link eines Moduls
   $module = new CHECK_MODULE($page);
   $check_module = $module->check();
   
   // Manuel angelegte Seite überprüfen
   $check_page   = false;
   if($check_module == false){
      $check_page = $url_parser->check_page();
   }
   
   if($check_module){
      // Modul init.php laden und includen
      require_once $module->get_init();
      
   } elseif($check_page){
      $template = new Template();
      $template->load($check_page);
      $tmpl = $template->display(true);
      $tmpl = $template->operators();
      echo $tmpl;
   } else {
      $template = new Template();
      $template->load("404_error");
      $template->assign("SITE_TITLE", "Seite nicht gefunden");
      $tmpl = $template->display(true);
      $tmpl = $template->operators();
      echo $tmpl;
   }
}