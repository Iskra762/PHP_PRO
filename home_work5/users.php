<?php
session_start();

include_once "config/authorization_check.php";
include_once "config/db.php";

$query = "SELECT username FROM users";
$result = $mysqli->query($query);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row['username'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Список користувачів</title>
</head>
<body>
    <h2>Список зареєстрованих користувачів</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
