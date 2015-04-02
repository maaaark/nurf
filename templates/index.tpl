<div class="prerenderedTemplates" style="display: none;">
	<!-- Vordefinierte "Templates" hier erstellen -->
	<div id="prerenderedPlayerElement" style="display: none;"> <!-- Player Element -->
		<table><tr>
			<td class="champion_icon"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/{CHAMPION_KEY}.png" class="champ_icon"></td>
			<td class="spells">
				<div><img src="http://flashignite.com/img/spells/{SPELL1ID}.png" class="spell_icon"></div>
				<div><img src="http://flashignite.com/img/spells/{SPELL2ID}.png" class="spell_icon"></div>
			</td>
			<td>
				<div class="summoner_name">{SUMMONER_NAME}</div>
				<div class="kills">kills</div>
			</td>
			<td class="gold_lasthits">
				<div class="gold">{TOTAL_GOLD}</div>
				<div class="lasthits">{LASTHITS}</div>
			</td>
			<td class="items">
				Items
			</td>
		</tr></table>
	</div>
</div>

<div class="match_holder">
	<div class="matchTeamBox blueTeam">
		<div class="teamName">Blue Team</div>
		<div class="teamPlayerHolder">
			<div id="blueTeamHolder" class="playerHolder"></div>
		</div>
	</div>

	<div class="matchTeamBox redTeam">
		<div class="teamName">Blue Team</div>
		<div class="teamPlayerHolder">
			<div id="redTeamHolder" class="playerHolder"></div>
		</div>
	</div>

	<div class="matchMapBox">
		<div id="map" class="map"></div>
	</div>

	<div>
		Aktuelle Minute: <span id="current_minute" style="font-weight: bold;">0</span>.
		<a href="javascript:void(0);" onclick="changeMinute('-');">Zur&uuml;ck</a>
		<a href="javascript:void(0);" onclick="changeMinute('+');">Weiter</a>
	</div>
</div>

<script type="text/javascript" src="matchViewer.js"></script>
<script>
	var matchData   = JSON.parse('{MATCH_DATA_JSON}');
	var current_min = 0;

	function changeMinute(val){
		if(val == "start"){
			val = 0;
		} else if(val == "+"){
			val = current_min + 1;
		} else {
			val = current_min - 1;
		}
		current_min = val;
		showMinute(matchData, val);
		document.getElementById("current_minute").innerHTML = val;
	}
	changeMinute("start");
</script>