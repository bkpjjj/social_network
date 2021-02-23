<?php
require_once 'config.php';

$login = $password = $conf_password = '';
$login_er = $password_er = $conf_password_er = '';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['login']))
        $login = $_POST['login'];
    if(isset($_POST['password']))
        $password = $_POST['password'];
    if(isset($_POST['conf_password']))
        $conf_password = $_POST['conf_password'];

    if(empty(trim($login)))
    {
        $login_er = 'Введите логин!';
    }
    else if(strlen(trim($login)) <= 3 || strlen(trim($login)) >= 32)
    {
        $login_er = 'Логин не должен быть меньше 3 и больше 32 символов.';
    }
    else
    {
        $sql = 'SELECT * FROM `Users` WHERE `Login` = ?';

        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, 's', $login);

            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $login_er = 'Пользватель с таким именем уже существует!';
                }
            }
            else
            {
                header('location: Oops.php');
            }

            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($password)))
    {
        $password_er = 'Введите пароль!';
    }
    else if(strlen(trim($password)) <= 6 || strlen(trim($password)) >= 16)
    {
        $password_er = 'Пароль не должен быть меньше 6 и больше 16 символов.';
    }
    if(empty(trim($conf_password)))
    {
        $conf_password_er = 'Введите пароль!';
    }
    else if($password != $conf_password)
    {
        $conf_password_er = 'Пароли должны совпадать.';
    }

    if(empty($login_er) && empty($password_er) && empty($conf_password_er))
    {
        $sql = 'INSERT INTO `Users`(`Login`,`Password`) VALUES (?,?)';

        if($stmt = mysqli_prepare($link, $sql))
        {
            mysqli_stmt_bind_param($stmt, 'ss', $login, password_hash($password, PASSWORD_DEFAULT));

            if(mysqli_stmt_execute($stmt))
            {
                header('location: welcome.php');
            }
            else
            {
                header('location: Oops.php');
            }

            mysqli_stmt_close($stmt);
        }
    }
}
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
            <input type="text" name="login" id="" value="<?php echo $login ?>"><br>
            <span><?php echo $login_er; ?></span><br>     
        </div>
        <div class="<?php echo empty($password_er) ? '' : 'has-error'; ?>">
            <label>Пароль:</label><br>
            <input type="password" name="password" id=""><br>
            <span><?php echo $password_er; ?></span><br>     
        </div>
        <div class="<?php echo empty($conf_password_er) ? '' : 'has-error'; ?>">
            <label>Подтвердите пароль:</label><br>
            <input type="password" name="conf_password" id=""><br>
            <span><?php echo $conf_password_er  ; ?></span><br>     
        </div>
        <div>
            <button type="submit">Вход</button>
            <button type="reset">Сброс</button>
            <a href="signin.php">Sign in</a>
        </div>
        </form>
    </div>
</body>
</html>