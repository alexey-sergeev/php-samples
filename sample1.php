<?php

  session_set_cookie_params(604800); // Хранить данные 1 неделю
  session_start();
  
  if ($_REQUEST["name"]) $_SESSION["name"] = $_REQUEST["name"]; 

  if ($_REQUEST["clear"] == "yes") {
    session_unset();
    session_destroy();
  } 

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Работа с сессиями</title>

</head>
<body>
<div id="wrap">

<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Работа с сессиями</a></h1>
<p>&nbsp;

<p>Ваше имя: <strong><?php echo $_SESSION["name"] ?></strong>  

<form action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <p><input type="text" name="name">
  <input type="submit" name="submit" value="Отправить">
</form>

<a href="?clear=yes">удалить имя</a>

<h2>Посчитать кроликов</h2>

<div class="navigation">
  <a href="?page=1">Первый кролик</a>
  <a href="?page=2">Второй кролик</a>
  <a href="?page=3">Третий кролик</a>
</div>

<div class="page">

  <?php if ($_REQUEST["page"] == "3") { ?>

    <img src="pictures/rabbit3.jpg">

  <?php } elseif ($_REQUEST["page"] == "2") { ?>

    <img src="pictures/rabbit2.jpg">

  <?php } else { ?>

    <img src="pictures/rabbit1.jpg">

  <?php } ?>

</div>

<div class="footer">
<p>Пример работы с сессиями на PHP
<p>Данный пример иллюстрирует возможность долговременного хранения данных в суперглобальном массиве $_SESSION. 
Значение переменной сохраняется при обновлении страниц и обращении к новым страницам сайта, после повторного обращения к сайту, а также после перезагрузки веб-сервера.
<p><a href="index.php">Посмотреть другие примеры</a>
<p>Волгоградский государственный социально-педагогический университет<br />
Сергеев А. Н., ноябрь 2015 г.
</div>
</div>
</body>
</html>