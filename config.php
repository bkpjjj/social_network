<?php
//Подключение к бд

define('DB_SERVER', null);
define('DB_NAME', 'social_network');
define('DB_PASS', null);
define('DB_USER', 'root');

$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
?>