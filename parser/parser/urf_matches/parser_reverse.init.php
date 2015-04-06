<?php
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

$parser = new URF_matchID_parser(strtotime($date), $region);
$result = $parser->parse();
echo '<div class="message '.$result["status"].'">'.$result["message"].'</div>';

?>