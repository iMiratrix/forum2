<?php
$server = $_SERVER['SERVER_ADDR'];
$username = 'root';
$password = 'root';
$dbname = 'forum14';
$charset = 'utf8';

$connection = new mysqli($server, $username, $password, $dbname);
$pdo = new PDO('mysql:host=localhost;dbname=forum14', 'root', 'root');

$site_url = 'http://forum2';

