<?php
session_start();

include_once "config/authorization_chek.php";
include_once "config/db.php";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Перевірка логіна та пароля в базі даних
    $query = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if(password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Введений логін або пароль неправильний.";
        }
    } else {
        $error = "Введений логін або пароль неправильний.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h2>Авторизація</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <label for="username">Логін:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Увійти">
    </form> 
    <button onclick="window.location.href='register.php'">Зареєструватися</button>
</body>
</html>
