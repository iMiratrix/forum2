<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {

    if (isset($_POST['sub'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $sql = 'SELECT * FROM `users`  WHERE `login` = ?';
        $params = [$login];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['permission'] = $user['permission'];
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['login'] = $user['login'];
                if ($_SESSION['permission'] == 1) {
                    header("Location:" . $site_url . "/modules/person.php");
                }
                if ($_SESSION['permission'] == 0)
                    header("Location:" . $site_url . "/admin_panel/admin.php");
            }
        } else {
            print("Неверный логин или пароль<br><a href='${site_url}'>Назад</a>");
        }
    } else {
        print("Неверный логин или пароль<br><a href='${site_url}'>Назад</a>");
    }

} else {
    header("Location:" . $site_url);
}


