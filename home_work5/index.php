<?php
session_start();

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h2>Привіт, <?php echo $username; ?>!</h2>
   
    
    <p> Натисніть нижче якщо бажаєте переглянути всіх користувачів сервісу </p>
        <button onclick="window.location.href='users.php'">зареєстровані користувачі</button>
    
        <button onclick="window.location.href='logout.php'">Залишити сайт</button>

</body>
</html>
