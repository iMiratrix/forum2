<?php
session_start();
require '../server/config.php';

echo <<<HTML

<body>
<div id="range1">
<div class="outer">
  <div class="middle">
    <div class="inner">

        <div class="login-wr">
          <h2>Регистрация</h2>
<form class="form" action="${site_url}/server/reg.php" method="post">
<input required type="text"  name="login" placeholder="Логин">
<input required type="email" name="email" placeholder="email">
<input required type="text" pattern="[А-Яа-яЁё ]+" name="name" placeholder="Имя (ru)">
<input required type="text" pattern="[А-Яа-яЁё ]+" name="surname" placeholder="Фамилия (ru)">
<input required type="text" pattern="[А-Яа-яЁё ]+" name="patronymic" placeholder="Отчество (ru)">
<input required id="p1" type="password" name="password" placeholder="Пароль">
<input required id="p2" type="password" name="password2" placeholder="Повторите пароль">
<br><label><input required type="checkbox"/>Согласие на обработку персональных данных </label>
<button onclick="check()" type="submit" name="sub">Регистрация</button>
</form>
<a href="${site_url}/modules/auth.php"><p>Авторизация</p></a>
</div>
        </div>

    </div>
  </div>
</div>
</div>
<script>
function check(){
   
if(document.getElementById('p1').value === document.getElementById('p2').value){
       
}else {
    alert('Пароли неверны');
}
}
</script>
</body>
<style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans|Roboto');

html, body {
    height : 100%;
    padding: 0;
    margin: 0;
}

body{
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
}

.outer {
    display: table;
    width: 100%;
    height: 100%;
    text-align: center;
}
.middle {
    display: table-cell;
    vertical-align: middle;
}
.inner {
    text-align: center;
    width: auto;
    padding: 0 15px;
}

#range1 {
 
    height: 100%;
    min-height: 400px;
}

#range1 .login-wr {
    position: relative;
    margin: 0 auto;
    background: #ecf0f1;
    max-width: 350px;
    border-radius: 5px;
    border-top: 4px solid #e74c3c;
    box-shadow: 3px 3px 10px #333;
    padding: 15px;
}

#range1 h2 {
    text-align: center;
    font-weight: 200;
    font-size: 2em;
    margin-top: 10px;
    color: #34495e;
}

#range1 .form {
    padding-top: 20px;
    text-align: center;
}

#range1 input[type="text"], 
#range1 input[type="email"],
#range1 input[type="password"],
#range1 button {
    width: 80%;
    margin-bottom: 25px;
    height: 40px;
    border-radius: 5px;
    outline: 0;
    -moz-outline-style: none;
}
      
#range1 input[type="text"],
#range1 input[type="email"],
#range1 input[type="password"] {
    border: 1px solid #bbb;
    padding: 0 0 0 10px;
    font-size: 14px;
}

#range1 a {
    text-align: center;
    font-size: 12px;
    color: #3498db;
}
      
#range1 button {
    background: #e74c3c;
    border:none;
    color: white;
    font-size: 18px;
    font-weight: 200;
    cursor: pointer;
    transition: box-shadow .4s ease;
}

</style>

HTML;

