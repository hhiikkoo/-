<?php
/**
 * @file register.php
 * @brief Страница регистрации пользователя
 *
 * Этот файл отвечает за регистрацию нового пользователя.
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "helpers.php";

$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Введите имя пользователя";
    } elseif (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', trim($_POST["username"]))) {
        $username_err = "Имя пользователя может содержать только буквы, цифры, точки и подчеркивания";
    } else {
        $sql = "SELECT id FROM Users WHERE login = '" . pg_escape_string(trim($_POST["username"])) . "'";
        $result = db_query($sql);
        if (pg_num_rows($result) > 0) {
            $username_err = "Это имя пользователя уже занято";
        } else {
            $username = trim($_POST["username"]);
        }
        pg_free_result($result);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Введите email";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Некорректный email формат";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Введите пароль";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Пароль должен содержать минимум 6 символов";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Подтвердите пароль";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Пароли не совпадают";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $sql = "INSERT INTO Users (login, password, email, role_key) VALUES ('" . pg_escape_string($username) . "', '" . pg_escape_string($password) . "', '" . pg_escape_string($email) . "', 'user')";
        if (db_query($sql)) {
            header("location: login.php");
        } else {
            echo "Что-то пошло не так. Попробуйте позже.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h2>Регистрация</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Имя пользователя</label>
            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Подтвердите пароль</label>
            <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Зарегистрироваться">
            <a href="login.php" class="btn btn-default">Отмена</a>
        </div>
    </form>
</div>
</body>
</html>