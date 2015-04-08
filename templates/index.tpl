<div class="prerenderedTemplates" style="display: none;">
	<!-- Vordefinierte "Templates" hier erstellen -->
	<div id="prerenderedPlayerElement" style="display: none;"> <!-- Player Element -->
		<table><tr>
			<td class="champion_icon"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/{CHAMPION_KEY}.png" class="champ_icon"></td>
			<td class="spells">
				<div><img src="http://flashignite.com/img/spells/{SPELL1ID}.png" class="spell_icon"></div>
				<div><img src="http://flashignite.com/img/spells/{SPELL2ID}.png" class="spell_icon"></div>
			</td>
			<td class="summoner_info"  valign="top">
				<div class="summoner_name">{SUMMONER_NAME}</div>
				<div class="kills">{KILLS} / {DEATH} / {ASSISTS}</div>
			</td>
			<td class="gold_lasthits">
				<div class="gold"><img src="assets/img/gold.png" > {TOTAL_GOLD}</div>
				<div class="lasthits"><img src="assets/img/minion.png" > {LASTHITS}</div>
			</td>
			<td class="items">
				<table cellspacing="0" cellpadding="0">
                    <tr>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                    </tr>
                    <tr>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                        <td height="22"><img src="http://ddragon.leagueoflegends.com/cdn/5.6.2/img/item/3089.png" width="22" /></td>
                    </tr>
                </table>
			</td>
		</tr></table>
	</div>
</div>

<div class="match_holder">
	<div class="matchTeamBox blueTeam">
		<div class="team_wrapper">
			<div class="teamName">Blue Team</div>
			<div class="teamPlayerHolder">
				<div id="blueTeamHolder" class="playerHolder"></div>
			</div>
		</div>
	</div>

	<div class="matchTeamBox redTeam">
		<div class="team_wrapper">
			<div class="teamName">Red Team</div>
			<div class="teamPlayerHolder">
				<div id="redTeamHolder" class="playerHolder"></div>
			</div>
		</div>
	</div>

	<div class="matchMapBox">
        <div id="team_scores">
            <div class="kills_blue">24</div>
			<div class="vs"><img src="assets/img/vs.png" alt="score" /></div>
            <div class="kills_red">16</div>
            <div class="gold_blue"><img src="assets/img/gold.png" > 20.2k</div>
            <div class="gold_red"><img src="assets/img/gold.png" > 19.3k</div>
        </div>
		<div class="map_frame">
			<div id="map" class="map"></div>
		</div>
        <div id="controls">
            <table>
                <tr>
                    <td width="120"><input type="range"  min="0" max="100" width="100" /></td>
                    <td width="75"><span id="current_minute" style="font-weight: bold;">0</span> Minute</td>
                    <td width="50">PLAY</td>
                    <td width="75"><a href="javascript:void(0);" onclick="changeMinute('-');">Zur&uuml;ck</a></td>
                    <td width="75"><a href="javascript:void(0);" onclick="changeMinute('+');">Weiter</a></td>
                </tr>
            </table>
            
        </div>
	</div>
</div>

<script type="text/javascript" src="events.js"></script>
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