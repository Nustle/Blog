<form <?=$form->method()?> class="form sign-up">
  <?=$form->inputSign()?>

  <?php foreach ($form->fields() as $field) : ?>
    <div>
      <?=$field?>
    </div>
  <?php endforeach; ?>
</form>