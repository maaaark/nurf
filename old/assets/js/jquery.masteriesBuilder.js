$.fn.mastery = function(masteries, icon_url){
	if(typeof masteries == "string"){
		masteries = JSON.parse(masteries);
	}
	
	console.log(masteries);
	object_id = Math.random().toString(36).substring(5, 12);
	object 	  = $(this);
	object.addClass("mastery_tree_holder");

	object.append('<div class="col-md-4"><div class="tree_type_holder offense"><div class="tree_bg_color"><div class="counter"></div><div class="tree_holder"></div></div></div></div>');
	object.append('<div class="col-md-4"><div class="tree_type_holder defense"><div class="tree_bg_color"><div class="counter"></div><div class="tree_holder"></div></div></div></div>');
	object.append('<div class="col-md-4"><div class="tree_type_holder utility"><div class="tree_bg_color"><div class="counter"></div><div class="tree_holder"></div></div></div></div>');

	count_offense = 0;
	count_defense = 0;
	count_utility = 0;

	checkIfSet = function(mastery_id){
		out = false;

		if(typeof masteries == "undefined" || typeof masteries.length == "undefined" || masteries.length <= 0){
			return false;
		}
		for(temp_i = 0; temp_i < masteries.length; temp_i++){
			if(mastery_id == masteries[temp_i]["id"]){
				if(typeof masteries[temp_i]["rank"] != "undefined" && masteries[temp_i]["rank"] > 0){
					out = masteries[temp_i]["rank"];
				} else {
					out = 1;
				}
			}
		}
		return out;
	}

	addMastery = function(mastery, type){
		style      = 'background-image: url('+icon_url.replace("{MASTERY_ID}", mastery["mastery_id"])+')';
		css_class  = 'mastery';
		inner_html = '';
		rank       = checkIfSet(mastery["mastery_id"]);
		if(rank && rank > 0){
			css_class  = 'mastery checked';
			inner_html = '<div class="ranks_holder">';
			for(rank_i = 0; rank_i < rank; rank_i++){
				inner_html += '<div class="rank_el"></div>';

				if(type == "offense"){
					count_offense++;
				}

				if(type == "defense"){
					count_defense++;
				}

				if(type == "utility"){
					count_utility++;
				}
			}
			inner_html += '</div>';
		}

		html  	  = '<div class="'+css_class+'" style="'+style+'">'+inner_html+'</div>';
		return html;
	}

	addInvisible = function(){
		html = '<div class="mastery invisible"></div>';
		return html;
	}

	runTree = function(type, tree){
		html = '';
		for(i = 0; i < tree.length; i++){
			row = tree[i];

			if(typeof row["masteryTreeItems"] != "undefined"){
				html += '<div class="tree_row">';
				for(x = 0; x < row["masteryTreeItems"].length; x++){
					element = row["masteryTreeItems"][x];

					if(element != null && typeof element["masteryId"] != "undefined"){
						html += addMastery(masteries_json[0][element["masteryId"]], type);
					} else {
						html += addInvisible();
					}
				}
				html += '</div>';
			}
		}
		object.find(".tree_type_holder."+type).find(".tree_holder").append(html);
	}

	runTree("offense", masteries_json[1]["Offense"]);
	runTree("defense", masteries_json[1]["Defense"]);
	runTree("utility", masteries_json[1]["Utility"]);

	object.find(".tree_type_holder.offense").find(".counter").html('<span>'+count_offense+'</span> - Angriff');
	object.find(".tree_type_holder.defense").find(".counter").html('<span>'+count_defense+'</span> - Abwehr');
	object.find(".tree_type_holder.utility").find(".counter").html('<span>'+count_utility+'</span> - Wissen');
}
