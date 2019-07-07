<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <link href="<?=ROOT?>assests/css/styles.css" rel="stylesheet" type="text/css">
  <title><?=$title?></title>
</head>

<body>
  <div id="wrapper">
    <header>
      <div class="header line">
        <div class="wrapper">
          <div class="logo"></div>
          <div class="slogan">
            <div class="title">Рога и копыта</div>
            <div class="subtitle">Всем по рогам, всем по копытам.</div>
          </div>
          <div class="phone">8 999 912 61 18</div>
        </div>
      </div>
      <div class="menu line">
        <div class="wrapper">
          <nav>
            <div class="show_menu">Меню</div>
            <ul>
              <li><a href="#">Главная</a></li>
              <li><a href="#">О компании</a></li>
              <li><a href="#">Продукты</a></li>
              <li><a href="#">Услуги</a></li>
              <li><a href="#">Контакты</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </header>
    <section>
      <div class="content line">
        <div class="wrapper">
          <aside class="left">
            <div class="col fl-l">
              <span class="h3">Оптовикам</span>
              <ul>
                <li><a href="#">Прайсы</a></li>
                <li><a href="#">Сорта рогов</a></li>
                <li><a href="#">Сроки поставки</a></li>
                <li><a href="#">Акции и скидки</a></li>
                <li><a href="#">Новинки</a></li>
              </ul>
            </div>
            <div class="col fl-r">
              <span class="h3">Простым покупателям</span>
              <ul>
                <li><a href="#">Прайсы</a></li>
                <li><a href="#">Сорта рогов</a></li>
                <li><a href="#">Сроки поставки</a></li>
                <li><a href="#">Акции и скидки</a></li>
                <li><a href="#">Новинки</a></li>
              </ul>
            </div>
            <div class="clear"></div>
          </aside>
          <section class="right">
            <?=$content?>
          </section>
          <div class="clear"></div>
        </div>
      </div>
    </section>
    <footer>
      <div class="footer line">
        <div class="wrapper">
          <span class="copy">&copy; ООО Рога и Копыта, Москва 2019, все права защищены!</span>
        </div>
      </div>
    </footer>
  </div>
  <script src="<?=ROOT?>assests/js/jquery-1.11.0.min.js" type="text/javascript"></script>
  <script src="<?=ROOT?>assests/js/scripts.js" type="text/javascript"></script>
</body>

</html>