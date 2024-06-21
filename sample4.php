<?php

  require_once("resize_crop.php");
  $h = 108;
  $w = 160;

  $show_msg = "";
  $l_error = false;
  $l_success = false;

  foreach ((array)$_FILES["files"]["tmp_name"] as $key => $tmp_name) {
    if ($_FILES["files"]["error"][$key] === UPLOAD_ERR_OK) {
      $name = $_FILES["files"]["name"][$key];

      // Проверить наличие файла и прибавить единицу
      while (file_exists("pictures/$name")) {
        $parts = pathinfo($name);
        $filename = explode("-", $parts["filename"]);
        if (is_numeric($filename[count($filename)-1])) {$filename[count($filename)-1]++;} else {$filename[]=1;};
        $name = implode("-", $filename) . "." . $parts["extension"];
      }

      if (move_uploaded_file($tmp_name, "pictures/$name")) {
        $l_success = true;      
      } else {
        $l_error = true;      
      };
    }
  }

  if ($l_success && !$l_error) $show_msg = "<div class=\"info\">Файлы успешно загружены на сайт</div>";
  if ($l_success && $l_error) $show_msg = "<div class=\"error\"><strong>Внимание!</strong> В процессе загрузки файлов возникли ошибки. Проверье перечень загруженных файлов</div>";
  if (!$l_success && $l_error) $show_msg = "<div class=\"error\"><strong>Ошибка!</strong> Загрузка файлов не удалась</div>";

  if (($_REQUEST["action"] == "delete") && isset($_REQUEST["page"])) {
    $name = $_REQUEST["page"];
   
    if (preg_match("/rabbit/", $name)) {

      $show_msg = "<div class=\"error\"><strong>Ошибка!</strong> Это кролик, не могу его удалить</div>";

    } elseif (file_exists("pictures/$name")) {

      if (unlink("pictures/$name")) { 

        $show_msg = "<div class=\"info\">Файл $name успешно удален</div>";
        unset($_REQUEST["page"]);

        $parts = pathinfo($name);                                                
        $file_mini = $parts["filename"]."-".$w."x".$h.".".$parts["extension"]; 
        if (file_exists("pictures-mini/$file_mini")) unlink("pictures-mini/$file_mini"); 

      } else {
        $show_msg = "<div class=\"error\"><strong>Ошибка!</strong> Не могу удалить файл $name</div>";    
      }

    } else {

      $show_msg = "<div class=\"error\"><strong>Ошибка!</strong> Файл $name не существует</div>";    

    }
  }

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Улучшенная загрузка файлов</title>

</head>
<body>
<div id="wrap">

<h1><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Улучшенная загрузка файлов</a></h1>
<p>&nbsp;

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
  <p><span class="nice_file_form" id="fileform1"><input type="file" name="files[]" multiple></span>
  <input type="submit" name="submit" value="Загрузить" onclick="document.getElementById('fileform1').className+=' loading'">
</form>

<?php if ($show_msg) echo $show_msg; ?>

<h2>Посчитать кроликов</h2>


<div class="navigation pic">

<?php

  $files = scandir("pictures");

  // Выбираем файл из GET-параметра, или первый файл из списка, 
  // если параметра или указанного файла не существует
  if ($_REQUEST["page"] && file_exists("pictures/" . $_REQUEST["page"])) {
    $page = $_REQUEST["page"] ;
  } else {
    foreach ($files as $file) {
      if (preg_match('/\.(jpg)/', $file)) { 
        $page = $file;
        break;
      }
    }
  }
   
  foreach ($files as $file) {
    if (preg_match('/\.(jpg)/', $file)) {
      $classname = ($file == $page) ? " class=\"current\"" : "";
      $parts = pathinfo($file);
      $file_mini = $parts["filename"]."-".$w."x".$h.".".$parts["extension"]; 
      if (!file_exists("pictures-mini/$file_mini")) resize("pictures/$file", "pictures-mini/$file_mini", $w, $h);
      echo "<a href=\"?page=$file\"$classname><img src=\"pictures-mini/$file_mini\"></a>";
    }
  }

?>

</div>

<div class="page">

  <img src="pictures/<?php echo $page ?>">

</div>

<div class="delete">
  <a href="?page=<?php echo $page ?>&action=delete">удалить картинку</a>
</div>

<div class="footer">
<p>Загрузка файлов на PHP-сайт
<p>Улучшенная реализация загрузки файлов на сайт. Добавлено: 1) можно загружать много файлов; 
2) при загрузке проверяются названия файлов и при совпадении к номеру файла добавляется единица;
3) в процессе загрузки отображается "живая" картинка;
4) можно удалять файлы (но не кроликов!); 5) масштабирование миниатюр производится на сервере.
<p><a href="index.php">Посмотреть другие примеры</a> 
<p>Волгоградский государственный социально-педагогический университет<br />
Сергеев А. Н., ноябрь 2015 г.
</div>
</div>
</body>
</html>