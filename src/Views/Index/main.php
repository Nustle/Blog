<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <link href="<?=ROOT?>public/css/styles.css" rel="stylesheet" type="text/css">
  <title><?=$title?></title>
</head>
<body>
  <div id="top-panel">
    <div class="base-container">
      <span class="inline-box signin">
        <a href="<?=ROOT?>user/sign-up">Регистрация</a> |
        <a href="<?=ROOT?>user/sign-in">Войти</a>
      </span>
    </div>
  </div>
  <div id="content-wrapper" class="base-container">
    <h1 class="main-title"><?=$title?></h1>
    <div class="content"><?=$content?></div>
  </div>
</body>
</html>