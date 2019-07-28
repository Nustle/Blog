<form method="post">
	Название<br>
	<input type="text" name="name" value="<?=$name?>"><br>
	Контент<br>
	<textarea name="content"><?=$content?></textarea><br>
	<input type="submit" value="Добавить">
</form> <br>
<div>
	<?=$errors?>
</div> <hr>
<a href="<?ROOT?>index/">Назад</a> <br>
