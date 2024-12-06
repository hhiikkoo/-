<?php
/**
 * @file login_welcome.php
 * @brief Страница приветствия пользователя после успешного входа
 *
 * Этот файл отвечает за отображение приветственного сообщения после
 * успешного входа пользователя. Также включает возможность разлогинивания.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="page-header">
    <h1>Здравствуйте, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Добро пожаловать в наш сайт.</h1>
</div>
<p>
    <a href="login_logout.php" class="btn btn-danger">Выйти из системы</a>
</p>
</body>
</html>
