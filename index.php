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

$template = new Template();
$template->load("index");
$template->assign("TEST", "Das ist eine Test Variable");
$tmpl = $template->display(true);
$tmpl = $template->operators();
echo $tmpl;