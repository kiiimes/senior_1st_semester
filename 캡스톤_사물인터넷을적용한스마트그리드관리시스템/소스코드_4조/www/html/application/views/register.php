<!DOCTYPE html>

<div>
	<?php echo validation_errors(); ?>
	<form action="/index.php/admin/register" method="post">
			<label for=id>ID</label>
			<input type="text" id="id" name="id" value="<?=set_value('id')?>" placeholder="ID"><br>
			<label fol="pw">PW</label>
			<input type="password" id="pw" name="pw" value="<?=set_value('pw')?>" plcaeholder="Password"><br>
			<label for=re_pw">RE-PW</label>
			<input type="password" id="re_pw" name="re_pw" value="<?=set_value('re_pw')?>" plcaeholder="Password Confirm"><br>
			<label for="name">NAME</label>
			<input type="text" id="name" name="name" value="<?=set_value('name')?>" plcaeholder="Name"><br>

		<input type="submit" value="Register">
	</form>
</div>

