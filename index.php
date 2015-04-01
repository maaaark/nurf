<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$content = file_get_contents("https://na.api.pvp.net/api/lol/na/v2.2/match/1778704162?includeTimeline=true&api_key=cc157cc5-58b2-417a-83ac-7d4579bd2d1d");
$json    = json_decode($content, true);

$array = array();
foreach($json["timeline"]["frames"] as $timeline_element){
	$minute_id = round($timeline_element["timestamp"] / 1000 / 60);
	//echo "<pre>", print_r($timeline_element), "</pre>";
	$temp = array();
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

	$array[$minute_id] = $temp;
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