<?php
session_start();
require '../server/config.php';
require '../template/header-user.php';
if (isset($_SESSION['permission'])) {
    if (isset($_POST['del'])) {
        $sth = $pdo->prepare("DELETE FROM `themes` WHERE `id_theme` = ?");
        $sth->execute([$_POST['del']]);
    }
    $stmt = $pdo->prepare("SELECT * FROM themes t LEFT JOIN images i ON t.id_image=i.id_image LEFT JOIN categories c ON t.id_category = c.id_category WHERE t.id_user=? AND (t.status) IN (?,?,?) ORDER BY t.date DESC");
    if (!isset($_POST['sort'])) {
        $stmt->execute([$_SESSION['id_user'], 0, 1, 2]);
    }
    if ($_POST['sort'] == '0') {
        $stmt->execute([$_SESSION['id_user'], $_POST['sort'], $_POST['sort'], $_POST['sort']]);
    }
    if ($_POST['sort'] == '1') {
        $stmt->execute([$_SESSION['id_user'], $_POST['sort'], $_POST['sort'], $_POST['sort']]);
    }
    if ($_POST['sort'] == '2') {
        $stmt->execute([$_SESSION['id_user'], $_POST['sort'], $_POST['sort'], $_POST['sort']]);
    }
    if ($_POST['sort'] == 'all') {
        $stmt->execute([$_SESSION['id_user'], 0, 1, 2]);
    }

    if ($stmt->rowCount() > 0) {
        print "<h1>Мои заявки:</h1>";
        echo <<<HTML
<form action="" method="post">
<select  class="form-control" name="sort">
 <option selected value="all">Все</option>
 <option value="0">Новые</option>
 <option value="1">Решена</option>
 <option value="2">Отклонено</option>
</select>
<input type="submit" value="Сортировка">
</form>
HTML;

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_theme = $data['id_theme'];
            $show_img = base64_encode($data['img']);


            switch ($data['status']) {
                case 0:
                    $status = "Новая <form action='' method='post'><button name='del' value='$id_theme'>Удалить</button></form>";

                    break;
                case 1:
                    $status = "Решена";
                    break;
                case 2:
                    $status = "Отклонена";
                    break;
            }
            echo <<<HTML

<body>

<h1>${data['title']}</h1>
<p>${data['text']}</p>
<p>${data['name_category']}</p>
<p>Создана: ${data['name']} ${data['surname']} ${data['date']}</p>
<p>Статус: ${status}</p>
<img width="350" height="350" src="data:image/jpeg;base64,${show_img}" alt="">

<hr>

HTML;
        }
    } else {
        print "<h1>Мои заявки:</h1>";
        echo <<<HTML
<form action="" method="post">
<select  class="form-control" name="sort">
 <option value="all">Все</option>
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