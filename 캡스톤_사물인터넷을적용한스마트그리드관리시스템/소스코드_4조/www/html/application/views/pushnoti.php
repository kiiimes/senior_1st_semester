
<div class="container">
	<div class="page-header">
		<h1>Push notification</h1>
	</div>

	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md 6">
				<form action="/index.php/push/push" method="post">
					<label for=title>title</label>
					<input type="text" id="title" name="title" value="<?=set_value('title')?>" placeholder="TITLE"><br>
					<label for="body">body</label>
					<input type="text" id="body" name="body" value="<?=set_value('body')?>" plcaeholder="BODY"><br>
					<input type="submit" value="Push">
				</form>
		</div>
	</div>
</div>



