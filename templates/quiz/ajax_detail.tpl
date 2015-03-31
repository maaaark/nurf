<div class="base">
	<div class="content">
		<h1>The question will be shown right here :)</h1>

		<div>
			This is the container for possible answer options.
		</div>
	</div>
</div>

<div class="base transparent">
	<div id="mastery_page_holder"></div>
	<div id="rune_page_holder"></div>
	<div id="team_viewer">
		<div class="team_holder left">
			<div class="holder">
				<div class="team_name">BLUE TEAM</div>
				<div class="player_holder">{BLUE_TEAM}</div>
			</div>
		</div>

		<div class="team_holder right">
			<div class="holder">
				<div class="team_name">RED TEAM</div>
				<div class="player_holder">{RED_TEAM}</div>
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>

<script>
$(document).ready(function(){
	$(".masteries_btn").click(function(){
		id 	 = $(this).attr("data-internalplayer");
		json = JSON.parse($("#player"+id+"_masteries").val());
		$("#mastery_page_holder").mastery(json, "http://ddragon.leagueoflegends.com/cdn/5.6.1/img/mastery/{MASTERY_ID}.png");
	});
});
</script>