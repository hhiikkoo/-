<?php
/**
 * @file login.php
 * @brief Страница входа в систему
 *
 * На данной странице происходит авторизация пользователя. В случае успешной авторизации
 * происходит перенаправление на страницу приветствия.
 *
 * @version 1.0
 * @date 16.04.2024
 */

session_start();
require_once "helpers.php";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: login_welcome.php");
    exit;
}

/// Переменные для входа
$username = $password = "";
/// Очищаем ошибки
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["asguest"]) && $_GET["asguest"] === "true") {
        $password_err = auth_by_username('guest', 'guest');
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $is_username_entered = isset($_POST["username"]) && !empty($_POST["username"]);
    $is_password_entered = isset($_POST["password"]) && !empty($_POST["password"]);
    if (!$is_username_entered) {
        $username_err = "Введите имя пользователя";
    } else {
        $username = trim($_POST["username"]);
    }
    if (!$is_password_entered) {
        $password_err = "Введите пароль";
    } else {
        $password = trim($_POST["password"]);
    }
    if ($is_username_entered && $is_password_entered) {
        $password_err = auth_by_username($username, $password);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница авторизации</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Логин</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary mb-3" value="Войти">
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?asguest=true" class="link">Войти как гость</a>
        </div>
    </form>
</div>
</body>
</html>