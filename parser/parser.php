<?php

require_once 'curl.func.php';
require_once '../system/config_db.php';
require_once '../system/mysql.class.php';
$GLOBALS["db"] = new MySQL(MYSQL_TYPE, MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB);

$speed   = 10; // 0 am schnellsten
$api_key = "cc157cc5-58b2-417a-83ac-7d4579bd2d1d";
$region  = "euw";

if(isset($_GET["resgion"])){
	$region = $_GET["region"];
}

$date = date("H:i d.m.Y", time() - (10 * 60));
$content = curl_file("https://".$region.".api.pvp.net/api/lol/".$region."/v4.1/game/ids?beginDate=".strtotime($date)."&api_key=".$api_key);
$json    = json_decode($content["result"], true);

if(isset($json["status"]) && isset($json["status"]["message"])){
	echo "<div style='padding:10px;border:1px solid black;margin:10px;'>";
	if($json["status"]["message"].trim() == "beginDate is invalid"){
		echo "Riot stellt in dieser Minute gerade keine MatchIDs zur Verf&uuml;gung.";
	} else {
		echo $json["status"]["message"]."</div>";
	}
	echo "</div>";
} else {
	$count       = 0;
	$count_added = 0;
	foreach($json as $matchID){
		$count++;
		$check = $GLOBALS["db"]->fetch_array($GLOBALS["db"]->query("SELECT * FROM urf_matchIDs WHERE matchID = '".$GLOBALS["db"]->real_escape_string($matchID)."'
																								 AND region = '".$GLOBALS["db"]->real_escape_string($region)."'"));

		if(!isset($check["id"]) || $check["id"] < 1){
			$insert = $GLOBALS["db"]->query("INSERT INTO urf_matchIDs SET matchID = '".$GLOBALS["db"]->real_escape_string($matchID)."',
																		  region  = '".$GLOBALS["db"]->real_escape_string($region)."',
																		  added   = '".$GLOBALS["db"]->real_escape_string(date("Y-m-d H:i:s"))."'");
			$count_added++;
		}
	}
	echo "Es wurden ".$count." URF-MatchIDs gefunden. Davon waren <b>".$count_added."</b> unbekannt und wurden gespeichert.";
}


$next 		 = $_SERVER["PHP_SELF"];
$stop_link 	 = $_SERVER['REQUEST_URI'];
if(strpos($stop_link, "?") > 0){
	$stop_link = $stop_link."&stop";
} else {
	$stop_link = $stop_link."?stop";
}

echo "<div style='margin-top:40px;'>";
if(isset($_GET["stop"])){
	echo "<a href='".str_replace("&stop", "", str_replace("?stop", "", $stop_link))."'>Starten</a>";
} else {
	echo "<a href='".$stop_link."'>Stoppen</a>";
	echo '<meta http-equiv="refresh" content="'.$speed.'; url='.$next.'">';
}
echo "</div>";

?>