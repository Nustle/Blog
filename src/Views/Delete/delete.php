<form <?= $form->method() ?> class="form delete">
  <?= $form->inputSign() ?>

  <?php foreach ($form->fields() as $field) : ?>
  <div>
    <?= $field ?>
  </div>
  <?php endforeach; ?>
</form>
<hr>
<a href="<? ROOT ?>index">Назад</a>