<?php
session_start();
require '../server/config.php';

if (isset($_SESSION['permission'])) {
    require "../template/header-admin.php";
    $stmt = $pdo->prepare("SELECT * FROM themes t LEFT JOIN images i ON t.id_image=i.id_image LEFT JOIN categories c ON t.id_category = c.id_category WHERE (t.status) IN (?) ORDER BY t.date DESC");
    $stmt->execute([0 | $_POST['sort']]);
    if ($stmt->rowCount() > 0) {
        print "<h1>Заявки:</h1>";
        echo <<<HTML
<form action="" method="post">
<select  class="form-control" name="sort">

 <option value="0">Новые</option>
 <option value="1">Решена</option>
 <option value="2">Отклонено</option>
</select>
<input type="submit" value="Сортировка">
</form>



HTML;
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $show_img = base64_encode($data['img']);
            switch ($data['status']) {
                case 2:
                case 1:
                    $status = "none";
                    break;
            }
            echo <<<HTML
<head>
<title>Заявки</title>
</head>
<body>

<h1>${data['title']}</h1>
<p>${data['text']}</p>
<p>${data['name_category']}</p>
<p>Создал: ${data['name']} ${data['surname']} ${data['date']}</p>

<img width="350" height="350" src="data:image/jpeg;base64,${show_img}" alt="">

<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="id_theme" value="${data['id_theme']}">
<input type="hidden" name="id_image" value="${data['id_image']}">
<input required type="file" name="img_upload">
<input style="display:$status;" type="submit" value="Решена" name="accept">
<input style="display:$status;" type="submit" value="Отклонить" name="reject">
</form>


HTML;
        }

        if (isset($_POST['accept'])) {
            $img_type = substr($_FILES['img_upload']['type'], 0, 5);
            $img_size = 6 * 1024 * 1024;
            $id_image = $_POST['id_image'];
            if (!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size) {
                $img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
                $connection->query("UPDATE images SET new_img = '$img' WHERE id_image = '$id_image' ");
                $stmt = $pdo->prepare("UPDATE `themes` SET `status` = 1 WHERE `id_theme` = ?");
                $stmt->execute([$_POST['id_theme']]);
                print "<a href='$site_url/admin_panel/admin.php'>Назад</a>";
            }

        }

    } else {
        print "<h1>Заявки:</h1>";
        echo <<<HTML
<form action="" method="post">
<select  class="form-control" name="sort">
 <option value="0">Новые</option>
 <option value="1">Решена</option>
 <option value="2">Отклонено</option>
</select>
<input type="submit" value="Сортировка">
</form>
HTML;

        print"<p>Нет заявок</p>";
    }
} else {
    header("Location:" . $site_url);
}
