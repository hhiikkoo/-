<?php
/**
 * @file helpers.php
 * @brief Сборник функций-помощников для работы с БД и сессиями
 *
 * @version 1.0
 * @date 16.04.2024
 */

require_once "database.php";

/**
 * Функция авторизации пользователя по логину и паролю
 *
 * @param string $username Логин пользователя
 * @param string $input_password Пароль пользователя
 * @return string|null Сообщение об ошибке или null, если ошибок нет
 */
function auth_by_username($username, $input_password)
{
    if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $username)) {
        return 'Невалидный логин';
    }
    $ferror = ""; // очищаем переменную ошибок
    $role_key = ""; // очищаем переменную роли
    $sql = "SELECT password, role, (SELECT description FROM userroles WHERE role = users.role) AS role_name FROM users WHERE login = '" . pg_escape_string($username) . "'";
    $result = db_query($sql);
    if ($result) {
        if ($frow = pg_fetch_row($result)) {
            $password = $frow[0];
            $role_key = $frow[1];
            $role_name = $frow[2];
            if ($input_password == $password) {
                $_SESSION["username"] = $username;
                $_SESSION["role_key"] = $role_key;
                $_SESSION["role_name"] = $role_name;
                $_SESSION["loggedin"] = true;
                if (isset($_SESSION["role_key"])) {
                    header("location: login_welcome.php");
                    exit;
                }
            } else {
                $ferror = "Неверный пароль";
            }
            pg_free_result($result); // очищаем результаты запроса
        } else {
            $ferror = "Пользователь не найден";
        }
    } else {
        $ferror = "Ошибка чтения роли: запрос не выполнен " . $sql;
    }
    return $ferror; // возвращаем ошибку, если произошла
}

/**
 * Функция открывает страницу с ошибкой
 *
 * @param string $message Сообщение об ошибке
 * @param string $redirect_url URL-адрес для перенаправления
 */
function open_error_page($message, $redirect_url)
{
    header("location: error_page.php?error=" . urlencode($message) . "&redirect=" . urlencode($redirect_url));
    exit;
}

/**
 * Функция выхода из системы
 */
function logout()
{
    session_start();
    $_SESSION = array();
    session_destroy();
    header("location: login.php");
    exit;
}

/**
 * Функция проверки роли пользователя
 *
 * @param string $req_role_key Ключ роли
 * @return bool
 */
function is_user_role($req_role_key)
{
    session_start();
    return isset($_SESSION["role_key"]) && $_SESSION["role_key"] == $req_role_key;
}

/**
 * Функция проверки авторизации пользователя
 */
function check_auth()
{
    session_start();
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        open_error_page("Вы не авторизованы", "login.php");
        exit;
    }
}