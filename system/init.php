<?php

// Datenbank verbindung herstellen
require_once 'system/config_db.php';
require_once 'system/mysql.class.php';
$GLOBALS["db"] = new MySQL(MYSQL_TYPE, MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB);

// Session start
session_start();