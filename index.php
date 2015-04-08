<?php
require_once 'system/config.php';
require_once 'system/init.php';


//$content = file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.2/match/2042419835?includeTimeline=true&api_key=cc157cc5-58b2-417a-83ac-7d4579bd2d1d");
$content = file_get_contents("http://localhost/match.json");
$json    = json_decode($content, true);
//echo "<pre>", print_r($json), "</pre>";


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


// Participants laden und diverse Infos laden (z.B. Champions)
$participants_data = array();
foreach($json["participants"] as $player){
	$champ = $GLOBALS["db"]->fetch_array($GLOBALS["db"]->query("SELECT * FROM champions WHERE champion_id = '".$GLOBALS["db"]->real_escape_string($player["championId"])."'"));
	$temp  = array();
	$temp["champion_name"] = str_replace("'", "&lsquo;", $champ["name"]);
	$temp["champion_key"]  = $champ["key"];

	$temp["spell1Id"]      = $player["spell1Id"];
	$temp["spell2Id"]      = $player["spell2Id"];
	$temp["teamId"]        = $player["teamId"];
	$temp["kills"]		   = 0;
	$temp["death"]		   = 0;
	$temp["assists"]	   = 0;
	$participants_data[$player["participantId"]] = $temp;
}


// Minutenweise durchlaufen
//echo "<pre>", print_r($json), "</pre>";
$array 				  = array();
$last_buildings_setup = null;
foreach($json["timeline"]["frames"] as $timeline_element){
	if(isset($_GET["pre"]) && $_GET["pre"] == "true"){
		echo "<pre style='background:white;'>", print_r($timeline_element), "</pre>";
	}
	$temp = array();
	$minute_id = round($timeline_element["timestamp"] / 1000 / 60);

	// Spieler laden
	$temp["player"] = array();
	foreach($timeline_element["participantFrames"] as $player){
		$player_arr = array();
		$player_arr["playerId"] 	 	     = $player["participantId"];
		$player_arr["summoner_name"] 	 	 = "Summoner Name";
		$player_arr["teamId"] 	 	 		 =  $participants_data[$player["participantId"]]["teamId"];
		$player_arr["spell1Id"]	 	 		 =  $participants_data[$player["participantId"]]["spell1Id"];
		$player_arr["spell2Id"] 	 	     =  $participants_data[$player["participantId"]]["spell2Id"];

		$player_arr["kills"] 	 	         =  $participants_data[$player["participantId"]]["kills"];
		$player_arr["death"] 	 	         =  $participants_data[$player["participantId"]]["death"];
		$player_arr["assists"] 	 	         =  $participants_data[$player["participantId"]]["assists"];

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

		$player_arr["champion_name"]         = $participants_data[$player["participantId"]]["champion_name"];
		$player_arr["champion_key"]          = $participants_data[$player["participantId"]]["champion_key"];

		$temp["player"][$player["participantId"]] = $player_arr;
	}

	// Gebäude laden
	if($last_buildings_setup == false){
		$buildings_temp = $builings;
	} else {
		$buildings_temp = $last_buildings_setup;
	}

	// Events durchlaufen
	$temp["events"] = array();
	if(isset($timeline_element["events"]) && is_array($timeline_element["events"])){
		foreach($timeline_element["events"] as $event){
			if(isset($event["eventType"])){
				// Event Typ analysieren
				if($event["eventType"] == "BUILDING_KILL"){	// Wenn ein Gebäude zerstört wurde
					if($event["buildingType"] == "TOWER_BUILDING"){	// Wenn es sich bei dem Gebäude um ein Turm handelt
						$lane  = $event["laneType"];
						$tower = $event["towerType"];

						$team  = "blue";
						if($event["teamId"] == 200){
							$team = "red";
						}

						if($lane == "MID_LANE" && $tower == "OUTER_TURRET"){ $buildings_temp["tower_mid_".$team."_1"] = false; }
						if($lane == "MID_LANE" && $tower == "INNER_TURRET"){ $buildings_temp["tower_mid_".$team."_2"] = false; }
						if($lane == "MID_LANE" && $tower == "BASE_TURRET"){  $buildings_temp["tower_mid_".$team."_3"] = false; }

						if($lane == "TOP_LANE" && $tower == "OUTER_TURRET"){ $buildings_temp["tower_top_".$team."_1"] = false; }
						if($lane == "TOP_LANE" && $tower == "INNER_TURRET"){ $buildings_temp["tower_top_".$team."_2"] = false; }
						if($lane == "TOP_LANE" && $tower == "BASE_TURRET"){  $buildings_temp["tower_top_".$team."_3"] = false; }

						if($lane == "BOT_LANE" && $tower == "OUTER_TURRET"){ $buildings_temp["tower_bot_".$team."_1"] = false; }
						if($lane == "BOT_LANE" && $tower == "INNER_TURRET"){ $buildings_temp["tower_bot_".$team."_2"] = false; }
						if($lane == "BOT_LANE" && $tower == "BASE_TURRET"){  $buildings_temp["tower_bot_".$team."_3"] = false; }
					}
				}

				else if($event["eventType"] == "CHAMPION_KILL"){	// Wenn ein Champion getötet wird
					if(isset($participants_data[$event["killerId"]]["kills"]) && isset($participants_data[$event["victimId"]]["death"])){
						$participants_data[$event["killerId"]]["kills"] = $participants_data[$event["killerId"]]["kills"] + 1;
						$participants_data[$event["victimId"]]["death"] = $participants_data[$event["victimId"]]["death"] + 1;

						if(isset($event["assistingParticipantIds"]) && is_array($event["assistingParticipantIds"])){
							foreach($event["assistingParticipantIds"] as $player_assist){
								$participants_data[$player_assist]["assists"] = $participants_data[$player_assist]["assists"] +1;
							}
						}

						// An Event Warteschlange anfügen
						$temp_arr = array();
						$temp_arr["type"] 	   = "CHAMPION_KILL";
						$temp_arr["timestamp"] = $event["timestamp"];
						$temp_arr["killerId"]  = $event["killerId"];
						$temp_arr["victimId"]  = $event["victimId"];
						$temp_arr["pos_x"]     = $event["position"]["x"];
						$temp_arr["pos_y"]     = $event["position"]["y"];
						$temp["events"][] = $temp_arr;
					}
				}
			}
		}
	}

	// Temp Array aktualisieren
	$temp["buildings"]  = $buildings_temp;

	// Daten speichern
	$array[$minute_id] 	  = $temp;
	$last_buildings_setup = $buildings_temp;
}


// Template anzeigen
$template = file_get_contents("templates/index.tpl");
$template = str_replace("{MATCH_DATA_JSON}", json_encode($array), $template);

$design   = file_get_contents("templates/design.tpl");
$design   = str_replace("{CONTENT}", $template, $design);
echo $design;
?>