<h4><a href="<?= ROOT ?>home?view=inline">Отобразить в линию</a></h4>
<div>
	<? foreach ($posts as $post) : ?>
		<strong>
			<a href="<?= ROOT ?>home/<?= $post['id'] ?>">
				<?= $post['name'] ?>
			</a>
		</strong>
		<hr>
	<? endforeach ?>
</div>
<a href="<?=ROOT?>home/add">Добавить</a><br>
<a href="<?=ROOT?>home/edit">Изменить</a><br>
<a href="<?=ROOT?>home/delete">Удалить</a><br>
<a href="<?=ROOT?>home/login">Регистрация</a>