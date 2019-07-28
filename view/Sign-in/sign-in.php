<form method="post">
  <p>
    <input type="text" name="login" placeholder="Введите логин">
  </p>
  <p>
    <input type="password" name="password" placeholder="Введите пароль">
  </p>
  <p>
    <input type="submit" value="Войти">
  </p>
  <p>
    <input type="checkbox" name="remember">
    Запомнить
  </p>
</form>
<div>
  <?=$errors?>
</div> <hr>
<a href="<?=ROOT?>user/sign-up">Зарегистрироваться</a>