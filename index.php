<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$content = file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/match/1778704162?includeTimeline=true&api_key=cc157cc5-58b2-417a-83ac-7d4579bd2d1d");
$json    = json_decode($content, true);


// Buildings Start Situation
$builings = array();
$builings["tower_top_red_1"] = true;
$builings["tower_top_red_2"] = true;
$builings["tower_top_red_3"] = true;
$builings["tower_mid_red_1"] = true;
$builings["tower_mid_red_2"] = true;
$builings["tower_mid_red_3"] = true;
$builings["tower_bot_red_1"] = true;
$builings["tower_bot_red_2"] = true;
$builings["tower_bot_red_3"] = true;

$builings["tower_top_blue_1"] = true;
$builings["tower_top_blue_2"] = true;
$builings["tower_top_blue_3"] = true;
$builings["tower_mid_blue_1"] = true;
$builings["tower_mid_blue_2"] = true;
$builings["tower_mid_blue_3"] = true;
$builings["tower_bot_blue_1"] = true;
$builings["tower_bot_blue_2"] = true;
$builings["tower_bot_blue_3"] = true;

$builings["tower_base_red_1"] = true;
$builings["tower_base_red_2"] = true;
$builings["tower_base_blue_1"] = true;
$builings["tower_base_blue_2"] = true;


// Minutenweise durchlaufen
$array 				  = array();
$last_buildings_setup = null;
foreach($json["timeline"]["frames"] as $timeline_element){
	$temp = array();
	$minute_id = round($timeline_element["timestamp"] / 1000 / 60);

	// Spieler laden
	$temp["player"] = array();
	foreach($timeline_element["participantFrames"] as $player){
		$player_arr = array();
		$player_arr["playerId"] 	 	     = $player["participantId"];
		if(isset($player["position"])){
			$player_arr["pos_x"]    	 	 = $player["position"]["x"];
			$player_arr["pos_y"]    	 	 = $player["position"]["y"];
		} else {
			$player_arr["pos_x"]    	 	 = 0;
			$player_arr["pos_y"]    	 	 = 0;
		}
		$player_arr["current_gold"]  	     = $player["currentGold"];
		$player_arr["total_gold"]   	     = $player["totalGold"];
		$player_arr["level"]         	     = $player["level"];
		$player_arr["xp"]            	     = $player["xp"];
		$player_arr["minions_killed"] 	     = $player["minionsKilled"];
		$player_arr["minions_killed_jungle"] = $player["jungleMinionsKilled"];
		$player_arr["lasthits"]              = $player["minionsKilled"] + $player["jungleMinionsKilled"];
		$player_arr["dominion_score"]        = $player["dominionScore"];
		$player_arr["team_score"]            = $player["teamScore"];

		$temp["player"][$player["participantId"]] = $player_arr;
	}

	// Gebäude laden
	if($last_buildings_setup == false){
		$buildings_temp = $builings;
	} else {
		$buildings_temp = $last_buildings_setup;
	}
	$temp["buildings"]  = $buildings_temp;

	// Daten speichern
	$array[$minute_id] 	  = $temp;
	$last_buildings_setup = $buildings_temp;
}

echo "<script>var matchData = JSON.parse('".json_encode($array)."');</script>";
?>

<div id="map"></div>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script type="text/javascript" src="matchViewer.js"></script>

<div>
	Aktuelle Minute: <span id="current_minute" style="font-weight: bold;">0</span>.
	<a href="javascript:void(0);" onclick="changeMinute('-');">Zur&uuml;ck</a>
	<a href="javascript:void(0);" onclick="changeMinute('+');">Weiter</a>
</div>
<script>
	var current_min = 0;
	showMinute(matchData, current_min);

	function changeMinute(val){
		if(val == "+"){
			val = current_min + 1;
		} else {
			val = current_min - 1;
		}
		current_min = val;
		showMinute(matchData, val);
		document.getElementById("current_minute").innerHTML = val;
	}
</script>