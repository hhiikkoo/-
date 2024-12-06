<?php
$host = '3b25edd57d8b.vps.myjino.ru';
$port = '49171';
$dbname = 'real_estate_catalog';
$user = 'root';
$pass = 'vengentisault';
$charset = 'utf8';

$dsn = "pgsql:host=$host;port=$port; dbname=$dbname;options='--client_encoding=$charset'";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$stmt = $pdo->query('SELECT * FROM order_statuses');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="styles.css">
    <title>Order Statuses</title>
</head>
<body>
    <h1>Order Statuses</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
