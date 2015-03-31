$.fn.runepage = function(rune_json, icon_pfad, on_finish){
	if(typeof rune_json == "string"){
		rune_json = JSON.parse(rune_json);
	}
	
	object = $(this);
	object.addClass("runepage");
	object.html('');
	
	holder = $("<div/>", { class: "runepage_bg" }).appendTo(object);
	
	// Runen laden
	for(i = 0; i < rune_json.length; i++){
		element = rune_json[i];
		rune  = $("<div/>", {
									class: "tool_tip rune runeslot_"+element["runeSlotId"],
								   style: "background-image:url("+icon_pfad.replace("{RUNE_ID}", element["runeId"])+");",
									title: "{RUNE="+element["runeId"]+"}"
								  }).appendTo(holder);
	}
	
	if(typeof on_finish != "undefined"){
		on_finish();
	}
}
