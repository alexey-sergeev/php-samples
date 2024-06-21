<?php

  session_start();
  
  $users = array(
                'max' => array( 'name' => 'Максим', 'password' => 'max11'),
                'kat' => array( 'name' => 'Екатерина', 'password' => 'kat12'),
                'rita' => array( 'name' => 'Маргарита', 'password' => 'rita22')  
              );

  if ($_REQUEST["login"]) {

    if (isset($users[$_REQUEST["login"]]) && $users[$_REQUEST["login"]]["password"] == $_REQUEST["password"]) {

      $_SESSION["login"] = $_REQUEST["login"];
      $_SESSION["name"] = $users[$_REQUEST["login"]]["name"];

    } else {

      $show_error = "<div class=\"error\"><strong>Ошибка!</strong> Логин или пароль указаны неверно</div>";

    }

  }
  
  if ($_REQUEST["logout"] == "yes") {

    session_unset();
    session_destroy();

  } 

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Проверка пользователя</title>

</head>
<body>
<div id="wrap">

<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Проверка пользователя</a></h1>
<p>&nbsp;


<?php if ($_SESSION["name"]) { ?>

  <p>Ваше имя: <strong><?php echo $_SESSION["name"] ?></strong>
  <p><a href="?logout=yes">Выйти</a>

<?php } else { ?>

  <?php if ($show_error) echo $show_error ?>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <p><input type="text" name="login" placeholder="Логин">
    <p><input type="password" name="password" placeholder="Пароль">
    <input type="submit" name="submit" value="Войти">
  </form>


<?php } ?>


<h2>Посчитать кроликов</h2>

<div class="navigation">
  <a href="?page=1">Первый кролик</a>
  <a href="?page=2">Второй кролик</a>
  <a href="?page=3">Третий кролик</a>
</div>

<?php if (isset($_SESSION['login'])) { ?>

<div class="page">

  <?php if ($_REQUEST["page"] == "3") { ?>

    <img src="pictures/rabbit3.jpg">

  <?php } elseif ($_REQUEST["page"] == "2") { ?>

    <img src="pictures/rabbit2.jpg">

  <?php } else { ?>

    <img src="pictures/rabbit1.jpg">

  <?php } ?>

</div>

<?php } else { ?>

<div class="page no-access">  
  
  <p>&nbsp;
  <p>&nbsp;
  <p><strong>Доступ закрыт</strong>
  <p>Пройдите авторизацию, прежде чем считать кроликов 
  <p>&nbsp;
  <p>&nbsp;

</div>

<?php } ?>


<div class="footer">
<p>Пример работы с сессиями на PHP
<p>Данный пример иллюстрирует возможность проверки учетных данных пользователя, а также ограничения доступа к разделам сайта неавторизованным пользователям.
<p><a href="index.php">Посмотреть другие примеры</a>
<p>Волгоградский государственный социально-педагогический университет<br />
Сергеев А. Н., ноябрь 2015 г.
</div>
</div>
</body>
</html>