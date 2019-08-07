<div class="row" style="text-align: center;">
	<h3>Current Power Source</h3>
	<h5 class="solar"><img src="/_include/img/solar.png" width="80px" height="80px">Solar Powered</h5>
	<h5 class="external"><img src="/_include/img/external.png" width="80px" height="80px">External Powered</h5>
	<h5 class="blackout"><img src="/_include/img/blackout.png" width="80px" height="80px">Blackout</h5>

</div>
<hr>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">

var ind;

$(document).ready(function(){
$('.solar').hide();
$('.external').hide();
$('.blackout').hide();
});
function getState(){
		$.ajax ({
url: "/index.php/system/jsonStateOfHouse",
dataType: "json",
cache: false,
contentType: "application/json; charset=utf-8",
crossDomain: true,
success: function(data){
	solar = parseInt(data.solar);
	external = parseInt(data.external);
	blackout = parseInt(data.blackout);

	if (blackout == 1){
		$('.blackout').show();
		$('.solar').show();
		$('.external').hide();
	}
	if(blackout == 0){
		$('.blackout').hide();
	if (solar == 1){
		$('.solar').show();
	}
	if (solar == 0){
		$('.solar').hide();
	}

	if (external == 1){
		$('.external').show();
	}
	if (external == 0){
		$('.external').hide();
	}
}

}
});

}

$(document).ready(function(){
	timer = setInterval(getState, 1000);
});	
</script>
