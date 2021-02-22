<?php

$login = $password = $conf_password = '';
$login_er = $password_er = $conf_password_er = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Регистрация</title>
</head>
<body>
    <div>
        <h2>Регистрация</h2>
        <p>Пожалуйста введите пароль</p>
        <form action="" method="post">
        <div class="<?php echo empty($login_er) ? '' : 'has-error'; ?>">
            <label>Логин:</label><br>
            <input type="text" name="" id=""><br>
            <span><?php echo $login_er; ?></span><br>     
        </div>
        <div class="<?php echo empty($password_er) ? '' : 'has-error'; ?>">
            <label>Пароль:</label><br>
            <input type="text" name="" id=""><br>
            <span><?php echo $password_er; ?></span><br>     
        </div>
        <div class="<?php echo empty($conf_password_er) ? '' : 'has-error'; ?>">
            <label>Подтвердите пароль:</label><br>
            <input type="text" name="" id=""><br>
            <span><?php echo $conf_password_er  ; ?></span><br>     
        </div>
        <div>
            <button type="submit">Вход</button>
            <button type="reset">Сброс</button>
        </div>
        </form>
    </div>
</body>
</html>