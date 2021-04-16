<?php
session_start();
require "../server/config.php";
require "../template/head.php";
if (isset($_SESSION['permission'])) {
    if ($_SESSION['permission'] == 0) {
        require "../template/header-admin.php";
    } else {
        require "../template/header-user.php";
    }
} else {
    echo <<<HTML

<div class="header">
   <a href="$site_url/modules/themes.php" class="logo"><img src="../img/logo.png" width="64" height="64" alt=""></a>
    <div class="header-right">
        <a href="$site_url/modules/auth.php">Авторизация<a>
        <a href="$site_url/modules/reg.php">Регистрация<a>
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

}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 4;
$offset = $limit * ($page - 1);
$stmt = $pdo->prepare("SELECT * FROM themes t LEFT JOIN images i ON t.id_image=i.id_image LEFT JOIN categories c ON t.id_category = c.id_category WHERE (t.status) IN (?) ORDER BY t.date DESC LIMIT $limit OFFSET $offset");
$stmt->execute([1]);
if ($stmt->rowCount() > 0) {
    print "<h1>Решенные заявки:</h1>";
    print "<select name='page-select' id='page-select'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
</select>
<script>
function getUrlParameter(url, parameter) {
  parameter = parameter.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?|&]' + parameter.toLowerCase() + '=([^&#]*)');
  var results = regex.exec('?' + url.toLowerCase().split('?')[1]);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function setUrlParameter(url, key, value) {

  var baseUrl = url.split('?')[0],
    urlQueryString = '?' + url.split('?')[1],
    newParam = key + '=' + value,
    params = '?' + newParam;


  if (urlQueryString) {
    var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
    var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

    if (typeof value === 'undefined' || value === null || value === '') { 
      params = urlQueryString.replace(removeRegex, '$1');
      params = params.replace(/[&;]$/, '');

    } else if (urlQueryString.match(updateRegex) !== null) { 
      params = urlQueryString.replace(updateRegex, '$1' + newParam);

    } else { 
      params = urlQueryString + '&' + newParam;
    }
  }

  params = params === '?' ? '' : params;

  return baseUrl + params;
}
var pageSelect = document.getElementById('page-select');
var currentPage = getUrlParameter(window.location.href,'page');

if (currentPage){
    pageSelect = currentPage;
}
pageSelect.addEventListener('change',function (event){
    var value = event.target.value;
    
    window.location.href = setUrlParameter(window.location.href,'page',value);
});
</script>";
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $show_img = base64_encode($data['img']);
        $show_img2 = base64_encode($data['new_img']);
        echo <<<HTML

<body>
<p>Раздел: ${data['name_category']}</p>
<p>${data['title']}</p>
<p>${data['date']}</p>
<div class="container">
<img class="img" width="350" height="350" src="data:image/jpeg;base64,${show_img}" alt="">
<img class="img2" width="350" height="350" src="data:image/jpeg;base64,${show_img2}" alt="">
</div>
</body> 


HTML;
    }
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_user'] == 2) {
            print "Вы заблокированы";
        } else {
            print "<br><a href='$site_url/modules/addtheme.php'>Добавить</a>";
        }
    }


} else {
    print "Нет заявок <a href='$site_url/modules/addtheme.php'>Создать</a><br>";
}

