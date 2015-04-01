<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="{DOMAIN}/assets/css/design.css">
	<link rel="stylesheet" type="text/css" href="{DOMAIN}/assets/css/teams.css">
	<link rel="stylesheet" type="text/css" href="{DOMAIN}/assets/css/jquery.masteriesBuilder.css">
	<link rel="stylesheet" type="text/css" href="{DOMAIN}/assets/css/jquery.runepageBuilder.css">

	<script>var domain = "{DOMAIN}";</script>
	<script type="text/javascript" src="{DOMAIN}/assets/js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="{DOMAIN}/assets/js/jquery.runepageBuilder.js"></script>
	<script type="text/javascript" src="{DOMAIN}/assets/js/jquery.masteriesBuilder.js"></script>

	<script>
	var masteries_json = [];
    $.get(domain+"/masteries.json", function(data){
		masteries_json = Object.keys(data).map(function(k){ return data[k] });
	});
    </script>
</head>
<body>
	<div class="body_precolor"></div>
	<div class="body_content_holder">
		<div class="main_navi">
			<div class="logo"><center>Logo</center></div>
			<div class="navigation">
				<div class="element">Quiz</div>
				<div class="element">Champions</div>
			</div>
		</div>
		{CONTENT}
	</div>
</body>
</html>