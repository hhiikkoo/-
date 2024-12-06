<?php
/**
 * @file error_page.php
 * @brief Страница отображения ошибок
 *
 * Этот файл используется для отображения сообщения об ошибке и перенаправления
 * пользователя на другую страницу после некоторого времени.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";

$message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : 'Неизвестная ошибка';
$redirect_url = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : 'login.php';
$redirect_delay = 5; // Задержка перед перенаправлением в секундах
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="<?php echo $redirect_delay; ?>;url=<?php echo $redirect_url; ?>">
    <title>Ошибка</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="page-header">
    <h1>Ошибка</h1>
    <p><?php echo $message; ?></p>
    <p>Вы будете перенаправлены через <?php echo $redirect_delay; ?> секунд.</p>
</div>
</body>
</html>
