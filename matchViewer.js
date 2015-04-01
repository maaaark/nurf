function showMinute(data, minute){
	if(typeof data[minute] != "undefined" && typeof data[minute]["player"] != "undefined"){
		// Daten der aktuellen Minute laden
		player_arr    = data[minute]["player"];
		buildings_arr = data[minute]["buildings"];

		// Variablen definieren
		var cords = [],
			domain = {
           		min: {x: -120, y: -120},
            	max: {x: 14870, y: 14980}
		    },
		    width = 512,
		    height = 512,
		    bg = "https://s3-us-west-1.amazonaws.com/riot-api/img/minimap-ig.png",
		    xScale, yScale, svg;

		// Spieler durchlaufen und Koordinaten + Champs speichern
		for(i in  player_arr){
			cords[cords.length] = [player_arr[i]["pos_x"], player_arr[i]["pos_y"], player_arr[i]["champion_name"], player_arr[i]["champion_key"]];
		}

		color = d3.scale.linear()
		    .domain([0, 3])
		    .range(["white", "steelblue"])
		    .interpolate(d3.interpolateLab);
		xScale = d3.scale.linear()
		  .domain([domain.min.x, domain.max.x])
		  .range([0, width]);
		yScale = d3.scale.linear()
		  .domain([domain.min.y, domain.max.y])
		  .range([height, 0]);

		// SVG setzen
		document.getElementById("map").innerHTML = '';
		svg = d3.select("#map").append("svg:svg")
		    .attr("width", width)
		    .attr("height", height);

		// Background Image setzen
		svg.append('image')
		    .attr('xlink:href', bg)
		    .attr('x', '0')
		    .attr('y', '0')
		    .attr('width', width)
		    .attr('height', height);

		// Champion Icons setzen
		svg.append('svg:g').selectAll("image")
		    .data(cords)
		    .enter().append("svg:image")
		        .attr('x', function(d) { return xScale(d[0]) - 10 })
		        .attr('y', function(d) { return yScale(d[1]) - 10 })
		        .attr('data-champ', function(d) { return d[2] })
		        .attr('width', 20)
		        .attr('height', 20)
		        .attr('class', 'champion_dot')
		        .attr('xlink:href', function(d) { return 'http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/'+d[3]+'.png' });

        // Buildings setzen
        for(building_type in buildings_arr){
        	current_building = buildings_arr[building_type];
        	check_value		 = "platzhalter_"+building_type;

        	if(check_value.indexOf("tower_") > 0){
        		x = 0;
        		y = 0;

        		team_icon_id     = 100;
        		if(building_type == "tower_top_red_1"){ x = 130; y = 32; team_icon_id = 200; }
        		if(building_type == "tower_top_red_2"){ x = 275; y = 32; team_icon_id = 200; }
        		if(building_type == "tower_top_red_3"){ x = 345; y = 32; team_icon_id = 200; }
        		if(building_type == "tower_mid_red_1"){ x = 300; y = 210; team_icon_id = 200; }
        		if(building_type == "tower_mid_red_2"){ x = 333; y = 155; team_icon_id = 200; }
        		if(building_type == "tower_mid_red_3"){ x = 370; y = 125; team_icon_id = 200; }
        		if(building_type == "tower_bot_red_1"){ x = 470; y = 340; team_icon_id = 200; }
        		if(building_type == "tower_bot_red_2"){ x = 457; y = 230; team_icon_id = 200; }
        		if(building_type == "tower_bot_red_3"){ x = 462; y = 155; team_icon_id = 200; }

        		if(building_type == "tower_top_blue_1"){ x = 25; y = 120; }
        		if(building_type == "tower_top_blue_2"){ x = 37; y = 253; }
        		if(building_type == "tower_top_blue_3"){ x = 31; y = 335; }
        		if(building_type == "tower_mid_blue_1"){ x = 220; y = 260; }
        		if(building_type == "tower_mid_blue_2"){ x = 180; y = 325; }
        		if(building_type == "tower_mid_blue_3"){ x = 120; y = 367; }
        		if(building_type == "tower_bot_blue_1"){ x = 360; y = 465; }
        		if(building_type == "tower_bot_blue_2"){ x = 220; y = 455; }
        		if(building_type == "tower_bot_blue_3"){ x = 152; y = 460; }

        		if(x != 0 && y != 0){
        			if(current_building){	// Überprüfen ob das Gebäude noch nicht zerstört wurde
						svg.select("g").append("svg:image")
					        .attr('x', x)
					        .attr('y', y)
					        .attr('width', 20)
					        .attr('height', 20)
					        .attr('class', 'tower_dot')
					        .attr('xlink:href', 'http://matchhistory.euw.leagueoflegends.com/assets/1.0.5/images/normal/event_icons/turret_'+team_icon_id+'.png');
			        } else {
			        	console.log("Gebäude wurde zerstört");
			        }
		        }
	        }
        }
	}
}