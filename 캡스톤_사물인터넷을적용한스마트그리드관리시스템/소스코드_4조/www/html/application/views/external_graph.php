<div class="row">
	<br>
	<div id="chart-wrap">
		<div id='chart-div'></div>
		<div id='control-div'></div>
	<div>
</div>
<div class="row" style="text-align: center;">
<a href="/index.php/home/solarGen">Change Graph</a>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

var chartDrawClass = {
	chartDraw: function(){
		var chartData = '';
		var chartDateFormat = 'mm/dd-hh:mm';
		var chartLineCount = 3;
		var controlLineCount = 10;

		function drawDashBoard() {
		data = new google.visualization.DataTable();

		data.addColumn('date', '시간');
		data.addColumn('number', 'KWh');

		$.ajax({
			url: "/index.php/graph/jsonExternalBattery/",      
			dataType:'json',                                   
			cache: 'false',                                    
			contentType: 'application/json; charset=utf-8', 
			async: false,  
			crossDomain: true, 
			success : function(json){
				for (var i in json){
					data.addRow([new Date(json[i].date), json[i].cons]);
				}
			}
		});

		var chart = new google.visualization.ChartWrapper({
			chartType   : 'LineChart',
			containerId : 'chart-div', //라인 차트 생성할 영역
			options     : {
				title: 'Electricity Consumption',
				isStacked	: 'percent',
				focusTarget	: 'category',
				height		: 500,
				width		: '100%',
				legend 		: { position: "top", textStyle: {fontSize: 13}},
				pointSize	: 1,
				tooltip		: {textStyle : {fontSize:12}, showColorCode : true,trigger: 'both'},
				hAxis 		: {	format: chartDateFormat, 
								gridlines: 	{	count:chartLineCount,units: 
												{
													years	: {format: ['yyyy년']},
													months	: {format: ['MM월']},
													days  	: {format: ['dd일']},
													hours 	: {format: ['HH시']}
												}
								},
								textStyle : {fontSize:12}
				},
			vAxis		: { viewWindow:{min:0},gridlines:{count:-1},textStyle:{fontSize:12}},
			animation	: {startup: true,duration: 1000,easing: 'in' },
			annotations	: {	pattern: chartDateFormat,
								textStyle: {
									fontSize: 15,
		  							bold: true,
									italic: true,
									color: '#871b47',
		 							auraColor: '#d799ae',
		  							opacity: 0.8,
		  							pattern: chartDateFormat
					}		
				}
			}
		});

		var control = new google.visualization.ControlWrapper({
			controlType	: 'ChartRangeFilter',
			containerId	: 'control-div',
			options	: {
					ui	: {
						chartType: 'LineChart',
						chartArea: {'width': '60%','height' : 80},
                        hAxis: {'baselineColor': 'none', format: chartDateFormat, textStyle: {fontSize:12},
                            gridlines:{count:controlLineCount,units: {
                            	years : {format: ['yyyy년']},
                                months: {format: ['MM월']},
                                days  : {format: ['dd일']},
                                hours : {format: ['HH시']}
								}
                           }
						}
            	},
				filterColumnIndex: 0
			}
		});

		var date_formatter = new google.visualization.DateFormat({pattern: chartDateFormat});
		date_formatter.format(data, 0);

		var dashboard = new google.visualization.Dashboard(document.getElementById('chart-wrap'));
		window.addEventListener('resize', function() { dashboard.draw(data); }, false);
		dashboard.bind([control], [chart]);
		console.log	(dashboard.draw(data));
		}

		google.charts.setOnLoadCallback(drawDashBoard);
	}
}

$(document).ready(function(){
	google.charts.load('current', { 'packages' : ['line', 'controls']});
	chartDrawClass.chartDraw();
});
</script>
