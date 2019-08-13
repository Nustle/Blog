<form <?=$form->method()?> class="form sign-in">
  <?=$form->inputSign()?>

  <?php foreach ($form->fields() as $field) : ?>
    <div>
      <?=$field?>
    </div>
  <?php endforeach; ?>
</form>
<a href="<?=ROOT?>user/sign-up" id="sign-up">Зарегистрироваться</a>