<div class="container">

	<div class="page-header">
		<h1>Function Test Page&emsp;<small>Change Rates</small></h1>
	</div>
	
	<div class="row">
		<div class="col-xs-3 col-sm-3 col-md-3"></div>
		<div class="col-xs-6 col-sm-6 col-md-6">
			<div class="hero-unit">	
				<h3>Change Rates</h3>	
				<p>시스템 테스트용 현재 부하 상태 변경 Signal 발생 버튼</p>
				<div class="btn-group">
					<button type="button" class="btn btn-danger" onclick="signal(1)">최대부하</button>
					<button type="button" class="btn btn-danger" onclick="signal(0)">중/경부하</button>	
				</div>
				<div id="result">
					<pre id="resdata"><strong>Result</strong><br></pre>
				</div>
			</div>
		</div>
		<div class="col-xs-3 col-sm-3 col-md-3"></div>     
	</div>	
</div>

<script type="text/javascript">

	document.getElementById('result').style.display = "none";
	function signal(flag){
		$.ajax({
			url : "/index.php/system/pubChange/" + flag,
			dataType: 'json',
			cache: false,
			contentType: 'application/json; charset=utf-8',
			crossDomain: true,
			success: function(data){
				console.log(data);

				$('#result').show();	
				$('#resdata').append('<br><h4><strong>Topic : ' + data.topic + '</strong></h4>');	
				$('#resdata').append('<h4><strong>Signal : ' + data.flag + '</strong></h4><hr>');
				$('#resdata').append('<p>'+ data.result +'</p>');
			}
		})
	}	
</script>
