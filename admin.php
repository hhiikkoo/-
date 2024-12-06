<?php
/**
 * @file admin.php
 * @brief Страница администрирования
 *
 * Этот файл отвечает за отображение страницы администрирования.
 * Доступен только пользователям с ролью администратора.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";
check_auth();

if (!is_user_role('admin')) {
    open_error_page('У вас нет прав для доступа к этой странице', 'login_welcome.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Администрирование</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="page-header">
    <h1>Администрирование</h1>
</div>
<p>
    <a href="login_welcome.php" class="btn btn-primary">Назад</a>
</p>
</body>
</html>
