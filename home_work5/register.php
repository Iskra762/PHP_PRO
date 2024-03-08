<?php
session_start();

include_once "config/authorization_chek.php";
include_once "config/db.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Будь ласка, заповніть всі поля.";
    } elseif (!preg_match('/^[a-zA-Z0-9]{4,10}$/', $username)) {
        $error = "Логін має містити лише латинські літери та цифри і бути від 4 до 10 символів.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$/', $password)) {
        $error = "Пароль має містити як мінімум одну букву та одну цифру і бути від 6 до 12 символів.";
    } elseif($password != $confirm_password) {
        $error = "Паролі не співпадають.";
    } else {
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0) {
            $error = "Цей логін вже зайнятий.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ss", $username, $hashed_password);
            if($stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $error = "Помилка при реєстрації.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h2>Реєстрація</h2>
    <?php if(isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST" action="">
        <label for="username">Логін:</label><br>
        <input type="text" id="username" name="username" pattern="[a-zA-Z0-9]{4,10}" title="Логін має містити лише латинські літери та цифри і бути від 4 до 10 символів." required><br>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,12}$" title="Пароль має містити як мінімум одну букву та одну цифру і бути від 6 до 12 символів." required><br>
        <label for="confirm_password">Підтвердіть пароль:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <input type="submit" value="Зареєструватися">
    </form>
    <button onclick="window.location.href='login.php'">Увійти</button>
</body>
</html>
