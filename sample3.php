<?php

  if (isset($_FILES['file']['tmp_name'])) {
  
    $file = basename($_FILES['file']['name']);
    $path = "pictures/" . $file; 

    if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
 
      $show_msg = "<div class=\"info\">Файл успешно загружен на сайт</div>";
      
    } else {
    
      $show_msg = "<div class=\"error\"><strong>Ошибка!</strong> Загрузка файла не удалась</div>";
    
    }

  }
    
?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Простая загрузка файлов</title>

</head>
<body>
<div id="wrap">

<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Простая загрузка файлов</a></h1>
<p>&nbsp;

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
  <p><input type="file" name="file">
  <input type="submit" name="submit" value="Загрузить">
</form>

<?php if ($show_msg) echo $show_msg; ?>

<h2>Посчитать кроликов</h2>


<div class="navigation pic">

<?php

  $files = scandir("pictures");
   
  foreach ($files as $file) {
    if (preg_match('/\.(jpg)/', $file)) { 
      echo "<a href='?page=$file'><img src='pictures/$file'></a>";
    }
  }

?>

</div>

<div class="page">

  <?php if ($_REQUEST["page"]) { ?>

    <img src="pictures/<?php echo $_REQUEST["page"] ?>">

  <?php } else { ?>

    <img src="pictures/rabbit1.jpg">

  <?php } ?>

</div>

<div class="footer">
<p>Загрузка файлов на PHP-сайт 
<p>Данный пример иллюстрирует простой способ загрузки файла на PHP-сайт. 
<p><a href="index.php">Посмотреть другие примеры</a>
<p>Волгоградский государственный социально-педагогический университет<br />
Сергеев А. Н., ноябрь 2015 г.
</div>
</div>
</body>
</html>