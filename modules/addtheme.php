<?php
session_start();
require '../server/config.php';
if (isset($_SESSION['permission'])) {
    if ($_SESSION['permission'] == 0) {
        require "../template/header-admin.php";
    } else {
        require "../template/header-user.php";
    }
    echo <<<HTML
<head>
<title>Добавить тему</title>
</head>
<body>
<br>
<form action="${site_url}/server/addtheme.php" method="post" enctype="multipart/form-data">
<select class="form-control" name="category">
HTML;

    $stmt = $pdo->prepare("SELECT * FROM `categories`");
    $stmt->execute();
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name_category = $data['name_category'];
        $id_category = $data['id_category'];
        echo <<<HTML
<option value="${id_category}">${name_category}</option>
HTML;
    }

    echo <<<HTML
</select>
<input type="text" name="title" placeholder="Заголовок">
<br>
<textarea name="text" id="" cols="30" rows="10" placeholder="Описание"></textarea>
<br>
<input type="file" name="img_upload">
<input type="submit" value="Добавить" name="upload">
</form>
</body>

HTML;
    if (isset($_GET['done'])) {
        print "Запись на модерации <a href='$site_url/modules/themes.php'>Назад</a>";
    }
    if (isset($_GET['errors'])) {
        print 'Заполните поля';
    }

} else {
    header("Location:" . $site_url);
}

