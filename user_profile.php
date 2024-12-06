<?php
/**
 * @file user_profile.php
 * @brief Страница профиля пользователя
 *
 * Этот файл отвечает за отображение и редактирование профиля пользователя.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";
check_auth();

$username = $_SESSION["username"];
$user_data = null;
$error_message = '';

$sql = "SELECT login, email, (SELECT name FROM Roles WHERE Roles.key = Users.role_key) AS role_name FROM Users WHERE login = '" . pg_escape_string($username) . "'";
$result = db_query($sql);

if ($result) {
    $user_data = pg_fetch_assoc($result);
    pg_free_result($result);
} else {
    $error_message = 'Ошибка загрузки данных профиля: ' . db_last_error();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $update_sql = "UPDATE Users SET email = '" . pg_escape_string($email) . "' WHERE login = '" . pg_escape_string($username) . "'";
        if (db_query($update_sql)) {
            $user_data['email'] = $email;
            $success_message = 'Профиль успешно обновлен';
        } else {
            $error_message = 'Ошибка обновления профиля: ' . db_last_error();
        }
    } else {
        $error_message = 'Неверный формат email';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h2>Профиль пользователя</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Логин</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['login']); ?>" disabled>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>">
        </div>
        <div class="form-group">
            <label>Роль</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user_data['role_name']); ?>" disabled>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Обновить">
            <a href="login_welcome.php" class="btn btn-default">Отмена</a>
        </div>
    </form>
</div>
</body>
</html>
