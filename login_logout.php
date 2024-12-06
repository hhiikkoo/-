<?php
/**
 * @file login_logout.php
 * @brief Обработчик разлогинивания пользователя
 *
 * Обработчик запроса на разлогинивание пользователя. Выполняет логическое
 * разлогинивание пользователя, закрывая его сессию. Затем перенаправляет на
 * страницу входа в панель управления.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";
logout();
?>