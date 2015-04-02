<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("RIOT_KEY", "cc157cc5-58b2-417a-83ac-7d4579bd2d1d");
require_once 'curl.func.php';
require_once '../system/config_db.php';
require_once '../system/mysql.class.php';
$GLOBALS["db"] = new MySQL(MYSQL_TYPE, MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB);

require_once 'urf_matchID.class.php';

$speed = 3;
$region  = "euw";

if(isset($_GET["region"])){
	$region = $_GET["region"];
}

$time = time();
if(isset($_GET["timestamp"])){
	$time = strtotime($_GET["timestamp"]);
}

$minutes = date("i", $time);
$diff    = $minutes % 5;
if($diff > 0){
	$minutes = $minutes - 5 - $diff;
	$time = $time - ($diff * 60) - (5 * 60);
}

$date = date("H:i d.m.Y", $time);
echo $date;

$parser = new URF_matchID_parser(strtotime($date), $region);
$result = $parser->parse();
echo '<div class="message '.$result["status"].'">'.$result["message"].'</div>';

$stop_link 	 = $_SERVER['REQUEST_URI'];
if(strpos($stop_link, "?") > 0){
	$stop_link = $stop_link."&stop";
} else {
	$stop_link = $stop_link."?stop";
}

$timestamp_next = date("H:i:s d.m.Y", strtotime($date) - (5 * 60));
echo "<div style='margin-top:40px;'>";
if(isset($_GET["stop"])){
	echo "<a href='".str_replace("&stop", "", str_replace("?stop", "", $stop_link))."'>Starten</a>";
} else {
	echo "<a href='".$stop_link."'>Stoppen</a>";
	echo '<meta http-equiv="refresh" content="'.$speed.'; url=?timestamp='.$timestamp_next.'">';
}
echo "</div>";
?>