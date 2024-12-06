<?php
/**
 * @file database.php
 * @brief Подключение к базе данных
 *
 * В данном файле происходит подключение к базе данных по заданным значениям.
 * После успешного подключения к базе данных, создается глобальная
 * переменная $db_connection, которую можно использовать в других скриптах.
 */

/**
 * Подключение к PostgreSQL базе данных.
 *
 * @return resource|false Соединение с базой данных или false в случае ошибки.
 */
function connectToPGSQL()
{
    $host = '3b25edd57d8b.vps.myjino.ru';
    $port = '49171';
    $dbname = 'real_estate_catalog';
    $user = 'root';
    $pass = 'vengentisault';
    $charset = 'utf8';

    $connectionString = "host={$host} port={$port} dbname={$dbname} user={$user} password={$pass} options='--client_encoding={$charset}'";

    $db_connection = pg_connect($connectionString);

    if ($db_connection === false) {
        die('Не удалось подключиться к базе данных');
    }

    return $db_connection;
}

// Устанавливаем глобальную переменную $db_connection
$db_connection = connectToPGSQL();

// Проверяем подключение к базе данных
if (!$db_connection) {
    die('Could not connect: ' . pg_last_error($db_connection));
}

/**
 * Выполнение запроса к базе данных
 *
 * @param string $query Запрос
 * @return resource Результат запроса
 */
function db_query($query)
{
    require_once 'helpers.php';

    if (str_contains($query, ';')) {
        open_error_page('SQL-injection detected', 'https://www.google.com');
    }

    global $db_connection;
    $result = pg_query($db_connection, $query) or die('Query failed: ' .  pg_last_error($db_connection));

    return $result;
}

/**
 * Получение последней ошибки базы данных
 *
 * @return string Последняя ошибка
 */
function db_last_error()
{
    global $db_connection;

    return pg_last_error($db_connection);
}
?>