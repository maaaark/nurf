function handleKill(svg, event){
	console.log(event);
	$("#player_"+event["victimId"]).css("opacity", "0.4");
}