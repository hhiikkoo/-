<?php
/**
 * @file index.php
 * @brief Главный файл приложения
 *
 * Этот файл является точкой входа в приложение,
 * здесь происходит проверка авторизации и перенаправление
 * пользователя на нужную страницу.
 *
 * @version 1.0
 * @date 16.04.2024
 */

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
} else {
    header("location: login_welcome.php");
}
exit;
?>
