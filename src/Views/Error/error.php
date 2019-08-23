<h2><?=$errorMessage?></h2>

<?php if ($dev) : ?>
<div>
  <?=$errorStackTrace?>
</div>
<?php endif ?>
<a href="<?=ROOT?>home">Начать с главной</a>