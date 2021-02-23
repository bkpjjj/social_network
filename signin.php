<?php
session_start();
    if(isset($_SESSION['loggedin']) && isset($_SESSION['loggedin']) == true)
    {
        header("location: Oops.php");
        exit;
    }
require_once 'config.php';

$username = $password = '';
$username_error = $password_error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(isset($_POST['username_login']))
    {
        $username = $_POST['username_login'];
    }
    if(isset($_POST['password_login']))
    {
        $password = $_POST['password_login'];
    }

    if(empty(trim($username)))
    {
        $username_error = 'Введите логин!';
    }
    else if(strlen(trim($username)) <= 3 || strlen(trim($username)) >= 32)
    {
        $username_error = 'Логин не должен быть меньше 3 и больше 32 символов.';
    }

    if(empty(trim($password)))
    {
        $password_error = 'Введите пароль!';
    }
    else if(strlen(trim($password)) <= 6 || strlen(trim($password)) >= 16)
    {
        $password_error = 'Логин не должен быть меньше 6 и больше 16 символов.';
    }


    if(empty($username_error) && empty($password_error)){

        $sql = "SELECT id, username, `password` FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $username;
            

            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            //тут указать ссылку на страницу
                            header("location: welcome.php");
                        } else{
                            $password_error = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_error = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../social_network/css/main.css">
    <link rel="stylesheet" type="text/css" href="../social_network/css/style-login.css">
    <title>Вход</title>
</head>
<body>
    <div class="layout-main_container">
        <form action="" method="post">
        <h1>Sign in</h1>   
            <div class="con-input">
                <input type="text" placeholder="login" name="username_login" value="<?php echo $username; ?>"/>
                <span><?php echo $username_error; ?></span>
            </div>
            <div class="con-input">
              <input type="password" placeholder="password" name="password_login"/>
              <span><?php echo $password_error; ?></span>
            </div>
            <div>
                <a href="#">forgot password</a>
                <input type="checkbox">Remember me</input> 
            </div>
            <div>
                <button class="button-login" type="submit">Вход</button>
                <span> OR </span>
                <a href="signup.php">Register</a>
            <div>
        </form>
    </div>
</body>
</html>