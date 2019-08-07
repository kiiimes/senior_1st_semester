<link href="/_include/FlipClock/compiled/flipclock.css" rel="stylesheet">

<!-- End Title Page -->
<div class="row" style="text-align: center;">
	<div class="fee-div" style="display: inline-block; width: auto;"></div>
</div>
<hr>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/_include/FlipClock/compiled/flipclock.js"></script>
<script type="text/javascript">

    var ind;
        function getCharge(){
            $.ajax ({
                url: "<?=$url?>",
                dataType: "json",
                cache: false,
                contentType: "application/json; charset=utf-8",
                crossDomain: true,
                success: function(data){
                    ind.setValue(data.measure + data.unit);
                }
            });

        }

	function unitSizing(){
		unit = $('.flip').last();
		if (window.matchMedia('(max-width: 400px)').matches){
			unit.css('width', '55px');
		} else if (window.matchMedia('(max-width: 500px)').matches){
			unit.css('width', '60px');
		} else{
			unit.css('width', '65px');
		}
	}

    $(document).ready(function(){
        
        timer = setInterval(getCharge, 1000);
        ind = new FlipClock($('.fee-div'), "0.000" + "<?=$unit?>", {
            clockFace: 'Counter',
            minimumDigits: 6
        });
		unitSizing();	
    });
	
	$(window).resize(function(){
		unitSizing();
	});
</script>
                  
