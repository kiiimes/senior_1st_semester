<div class="row" style="text-align: center;">
<div id='level' style="display: inline-block"></div>
<div id='gauge' style="display: inline-block"></div>
<div>

<hr>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', { 'packages' : ['gauge']});
google.charts.setOnLoadCallback(drawChart);
google.charts.setOnLoadCallback(drawLevel);

function drawLevel(){
	var data = new google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['Solar Battery', 0]
	]);
	
	var options = {
        redFrom: 0, redTo: 15,
        yellowFrom:15, yellowTo: 30,
        minorTicks: 5
	};
	
	var chart = new google.visualization.Gauge(document.getElementById('level'));
	var formatter = new google.visualization.NumberFormat({suffix: '%', fractionDigits: 1});	
	setLevelAndDraw();
	setInterval(setLevelAndDraw, 1000);


	function setLevelAndDraw(){
		
		$.ajax({
			url: "/index.php/System/jsongetcurrentlevel",
			dataType:'json',
			cache: 'false',
			contentType: 'application/json; charset=utf-8',
			async: false,
			crossDomain: true,
			success : function(json){
				data.setValue(0, 1, json.measure);
			}		
		});
		formatter.format(data,1);
		chart.draw(data,options);
	}
}
function drawChart(){

	var data = new google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['Consumption', 0],
		['Solar', 0]
	]);

	var options = {
		min: 0, max: 20,
        redFrom: 18, redTo: 20,
        yellowFrom:12, yellowTo: 18,
        minorTicks: 5
	};
	
	var chart = new google.visualization.Gauge(document.getElementById('gauge'));
	var formatter = new google.visualization.NumberFormat({suffix: 'W', fractionDigits:2});
 
	setLevelAndDraw();
	setInterval(setLevelAndDraw, 1000);


	function setLevelAndDraw(){
	
	$.ajax({
		url: "/index.php/System/jsongetkwh",
		dataType:'json',
		cache: 'false',
		contentType: 'application/json; charset=utf-8',
		async: false,
		crossDomain: true,
		success : function(json){
			data.setValue(0, 1, json.measure);
		}		
	});
	$.ajax({
		url: "/index.php/System/jsongetsolarkwh",
		dataType:'json',
		cache: 'false',
		contentType: 'application/json; charset=utf-8',
		async: false,
		crossDomain: true,
		success : function(json){
			data.setValue(1, 1, json.measure);
		}		
	});
		formatter.format(data, 1);		
		chart.draw(data, options);
	}
	
}
</script>
