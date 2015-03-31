<div id="index_main_holder">
	<div class="base">
		<div class="content">
			<h1 class="site_title">Start the quiz</h1>
			To start the quiz just click the following button. We willl give you some questions about random matches of the
			new League of Legends GameMode "N.U.R.F." which you can answer by clicking on some options.

			<div style="text-align:center;margin-top:25px;"><button class="big" id="start_quiz">Start the quiz</button></div>
		</div>
	</div>
</div>

<div id="quiz_main_holder" style="display: none;height: 0px;">
	<div class="base">
		<div class="content">
			<div style="text-align:center;margin-top:20px;">
				<img src="http://counterpick.de/assets/img/ajax-loader.gif" style="height: 80px;">
				<div style="margin-top:15px;color:rgba(0,0,0,0.6);">
					Quiz data is loading ... Please wait a few seconds ...
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	var animation_settings = {
		speed: 700,
		type:  "swing"
	};

	$("button#start_quiz").click(function(){
		$("#index_main_holder").animate({"margin-top": "-100px", "margin-bottom": "100px", "opacity": "0", "height" : "0px"}, animation_settings.speed, animation_settings.type, function(){
				$("#index_main_holder").hide();
		});

		$("#quiz_main_holder").css("margin-top", "100px");
		$("#quiz_main_holder").css("opacity", "0");
		$("#quiz_main_holder").show();
		$("#quiz_main_holder").animate({"margin-top": "0px", "opacity": "1"}, animation_settings.speed, animation_settings.type, function(){
			$("#index_main_holder").animate({"margin-top": "0", "margin-bottom": "0"}, 1500, "linear", function(){
				$.get(domain+"/quiz/ajax/get").done(function(data){
					$("#quiz_main_holder").html(data);
				});
			});
		});
	});
});
</script>