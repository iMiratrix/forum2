<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id'])) {
    if (isset($_POST['sub'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $login = $_POST['login'];
        $patronymic = $_POST['patronymic'];
        if (!empty($email) && !empty($password) && !empty($name) && !empty($surname) && !empty($login) && !empty($patronymic)) {
            $sql_check = 'SELECT EXISTS(SELECT `login` FROM `users`  WHERE login = ?)';
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute([$login]);
            if ($stmt_check->fetchColumn()) {
                print("Такой логин уже используется<br><a href='${site_url}/modules/reg.php'>Назад</a>");
                die();
            }
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'INSERT INTO `users` (`email`, `password`, `name`, `surname`, `permission`, `login`,`patronymic`) VALUES(?, ?, ?, ?, ?,?,?)';
            $params = [$email, $password, $name, $surname, 1, $login, $patronymic];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            if ($stmt->rowCount() > 0) {
                header("Location:" . $site_url."/modules/auth.php");
            }
        } else {
            print("Заполните поля<br><a href='${site_url}/modules/reg.php'>Назад</a>");
        }
    }
} else {
    header("Location:" . $site_url);
}

