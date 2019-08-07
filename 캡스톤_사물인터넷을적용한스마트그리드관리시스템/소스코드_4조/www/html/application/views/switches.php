<!-- Our Work Section -->
<div id="work" class="page">
	<div class="container">
		<!-- Title Page -->
		<div class="row">
			<div class="span12">
				<div class="title-page">
					<h2 class="title">Switch ON/OFF</h2>
				</div>
				<hr>
			</div>
		</div>
		<!-- End Title Page -->

		<!-- Portfolio Projects -->
		<div class="row">
			<div class="span4"></div>

			<div class="span8">
				<div class="row">
					<section id="projects">

						<?php
						foreach($list as $l):
						?>
							<div class="span4 checkbox" style="float: left">
								<h3 style="margin: 10px 0 10px 0;"><strong style="float: left;"><?php echo ($l->name == '' ? 'NO NAME' : $l->name); ?></strong>		
								<!-- Rounded switch -->
								<label class="switch" style="vertical-align: middle; float: right;">
									<input type="checkbox" class="cbox_slider" value="<?=$l->id?>">
									<span class="slider round"></span>
								</label>
</h3>
							</div>

						<?php
						endforeach;
						?>
					</section>

				</div>
			</div>
		</div>
	<!-- End Portfolio Projects -->
	</div>

</div>

<!-- End Our Work Section -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 
<script>
$(document).ready(function(){
    $(".cbox_slider").change(function(){
        if($(this).is(":checked")){
			signal($(this).prop('value'), '1');
        }else{
			signal($(this).prop('value'), '0');
        }
    });
});

function signal(id, flag){
	$.ajax({
		url : "/index.php/system/pubSwitchControl/" + id + "/" + flag,
    	dataType: 'json',
		cache: false,
		contentType: 'application/json; charset=utf-8',
		crossDomain: true,
		success: function(data){
			console.log(data);
		}
	})
}
</script>

