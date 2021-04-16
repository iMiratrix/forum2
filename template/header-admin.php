<?php
require "../server/config.php";
echo <<<HTML
<div class="header">
    <a href="$site_url/modules/themes.php" class="logo"><img src="../img/logo.png" width="64" height="64" alt=""></a>
    <div class="header-right">
        <a href="$site_url/admin_panel/admin.php">Админ панель<a>
        <a href="$site_url/admin_panel/categories.php">Категории</a>
        <a href="$site_url/server/logout.php">Выйти из записи</a>
    </div>
</div>
<style>
    * {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial;
}
    .header {
        overflow: hidden;
        background-color: #f1f1f1;
        padding: 20px 10px;
    }

    .header a {
        float: left;
        color: black;
        text-align: center;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
    }


    .header a.logo {
        font-size: 25px;
        font-weight: bold;
    }

    .header a:hover {
        background-color: #ddd;
        color: black;
    }


    .header a.active {
        background-color: dodgerblue;
        color: white;
    }


    .header-right {
        float: right;
    }


    @media screen and (max-width: 500px) {
        .header a {
            float: none;
            display: block;
            text-align: left;
        }
        .header-right {
            float: none;
        }
    }
</style>

HTML;

?>
