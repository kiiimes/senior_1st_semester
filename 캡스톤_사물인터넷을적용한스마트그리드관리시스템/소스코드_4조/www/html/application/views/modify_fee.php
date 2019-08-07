<!DOCTYPE html>
<html>
<?php $keys = array_keys($data); ?>

<?php foreach($keys as $k):?>
		<h2><?=$k?></h2>
	<?php 
		$col = array_keys($data[$k]);
		foreach($col as $c):
	?>
		<h4><?=$c?></h4>
		<p><?=print_r($data[$k][$c])?></p>

	<?php endforeach; ?>
<?php endforeach; ?>
<p>check data</p>
<form action="/index.php/system/modifyFeePage" method="post">
	<label for="kwh">kWh</label>
	<input type="text" id="kwh" name="kwh" placeholder="kwh" />
	<input type="submit" value="check"/>
	<h3><?=$value?></h3> 
</form>

</html>
