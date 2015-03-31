<?php

if(isset($url_arr[1]) && $url_arr[1] == "ajax"){
	if(isset($url_arr[2]) && $url_arr[2] == "get"){
		$content   = file_get_contents("https://euw.api.pvp.net/api/lol/euw/v2.2/match/2038753002?includeTimeline=true&api_key=cc157cc5-58b2-417a-83ac-7d4579bd2d1d");
		$json      = json_decode($content, true);

		$red_team  = "";
		$blue_team = "";
		if(isset($json["participants"]) && is_array($json["participants"])){
			foreach($json["participants"] as $player){
				//echo "<pre>", print_r($player), "</pre>";
				if(isset($player["championId"]) && isset($player["stats"]) && isset($player["teamId"])){
					$team = "blue";
					if($player["teamId"] == 200){
						$team = "red";
					}

					$template = new Template;
					$template->load("quiz/ajax_player");

					$champion = $GLOBALS["db"]->fetch_array($GLOBALS["db"]->query("SELECT * FROM champions WHERE champion_id = '".$GLOBALS["db"]->real_escape_string($player["championId"])."'"));
					foreach($champion as $column => $value){
						$template->assign("CHAMPION_".strtoupper($column), $value);
					}

					foreach($player["stats"] as $column => $value){
						$template->assign("STATS_".strtoupper($column), $value);

						$item = $GLOBALS["db"]->fetch_array($GLOBALS["db"]->query("SELECT * FROM items WHERE item_id = '".$GLOBALS["db"]->real_escape_string($value)."'"));
						if(isset($item["id"]) && $item["id"] > 0){
							foreach($item as $item_column => $item_value){
								$template->assign(strtoupper($column."_".$item_column), $item_value);
							}
						}
					}

					$template->assign("TEAM_TYPE", $team);
					if($team == "blue"){
						$blue_team .= $template->display();
					} else {
						$red_team  .= $template->display();
					}
				}
			}
		}

		// Neues Quiz erstellen
		$template = new Template();
		$template->load("quiz/ajax_detail");
		$template->assign("RED_TEAM", $red_team);
		$template->assign("BLUE_TEAM", $blue_team);
		echo $template->display();
	}
}

?>