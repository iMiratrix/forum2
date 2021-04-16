<?php
session_start();
require '../server/config.php';

if (isset($_SESSION['permission'])) {
require "../template/header-admin.php";

    if (isset($_POST['del'])) {
        $sth = $pdo->prepare("DELETE FROM `categories` WHERE `id_category` = ?");
        $sth->execute([$_POST['del']]);
    }

    if (isset($_POST['add'])){
        $stmt2 = $pdo->prepare("INSERT INTO categories(name_category) VALUES (?)");
        $stmt2->execute([$_POST['name_category']]);
    }

    $stmt = $pdo->prepare("SELECT * FROM categories");
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_category = $data['id_category'];
            echo <<<HTML
<html lang="en">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Document</title>
</head>
<body>
  <p>${data['name_category']}</p> <form action='' method='post'><button name='del' value='$id_category'>Удалить</button></form>

HTML;

        }
        echo <<<HTML
<form action="" method="post">
<input type="text" placeholder="Название категории" name="name_category">
<input type="submit" name="add" value="Добавить">
</form>
</body>
</html>
HTML;

    }
} else {
    header("Location:" . $site_url);
}

