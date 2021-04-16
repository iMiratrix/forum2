<?php
session_start();
require 'config.php';
if (isset($_SESSION['permission'])) {
    if (isset($_POST['upload'])) {
        $img_type = substr($_FILES['img_upload']['type'], 0, 5);
        $img_size = 6 * 1024 * 1024;
        if (!empty($_FILES['img_upload']['tmp_name']) and $img_type === 'image' and $_FILES['img_upload']['size'] <= $img_size) {
            $img = addslashes(file_get_contents($_FILES['img_upload']['tmp_name']));
            $title = ucfirst($_POST['title']);
            $text = $_POST['text'];
            $id_user = $_SESSION['id_user'];
            $today = date("Y-m-d H:i:s");
            $status = "0";
            $id_category = $_POST['category'];
        }

        if (!empty($title) & !empty($text)) {
            $connection->query("INSERT INTO images (img, new_img) VALUES ('$img','$img')");
            $last_id = mysqli_insert_id($connection);
            $query = ("INSERT INTO `themes` (`id_user`,`title`,`text`,`date`,`status`,`id_category`,`id_image`) VALUES (?, ?, ?, ?, ?,?,?)");
            $stmt = $connection->prepare($query);
            $stmt->bind_param("ssssssi", $id_user, $title, $text, $today, $status, $id_category, $last_id);
            $stmt->execute();


            if ($stmt) {
                header("Location:" . $site_url . "/modules/addtheme.php?done=done");
            } else {
                header("Location:" . $site_url . "/modules/addtheme.php?errors=true");
            }
        } else {
            header("Location:" . $site_url . "/modules/addtheme.php?errors=true");
        }
    } else {
        header("Location:" . $site_url);
    }
} else {
    header("Location:" . $site_url);

}
