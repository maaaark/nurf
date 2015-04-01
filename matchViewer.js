function showMinute(data, minute){
	if(typeof data[minute] != "undefined" && typeof data[minute]["player"] != "undefined"){
		player_arr = data[minute]["player"];

		var cords = [],
			domain = {
           		min: {x: -120, y: -120},
            	max: {x: 14870, y: 14980}
		    },
		    width = 512,
		    height = 512,
		    bg = "https://s3-us-west-1.amazonaws.com/riot-api/img/minimap-ig.png",
		    xScale, yScale, svg;

		for(i in  player_arr){
			//console.log(player_arr[i]);
			cords[cords.length] = [player_arr[i]["pos_x"], player_arr[i]["pos_y"], "ahri"];
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

		document.getElementById("map").innerHTML = '';
		svg = d3.select("#map").append("svg:svg")
		    .attr("width", width)
		    .attr("height", height);

		svg.append('image')
		    .attr('xlink:href', bg)
		    .attr('x', '0')
		    .attr('y', '0')
		    .attr('width', width)
		    .attr('height', height);

		/*defs = svg.append('defs');
		pattern = defs.append('pattern')
					.attr('id', 'image')
					.attr('x', '0')
					.attr('y', '0')
					.attr('patternUnits', 'userSpaceOnUse')
					.attr('height', '40')
					.attr('width', '40');
		pattern.html('<image x="0" y="0" xlink:href="http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/Ahri.png" />');*/

		svg.append('svg:g').selectAll("image")
		    .data(cords)
		    .enter().append("svg:image")
		        .attr('x', function(d) { return xScale(d[0]) - 10 })
		        .attr('y', function(d) { return yScale(d[1]) - 10 })
		        .attr('data-champ', function(d) { return d[2] })
		        .attr('width', 20)
		        .attr('height', 20)
		        .attr('class', 'champion_dot')
		        .attr('xlink:href', 'http://ddragon.leagueoflegends.com/cdn/5.6.1/img/champion/Ahri.png');
			}
}