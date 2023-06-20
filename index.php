<?php
session_start();


if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    $_SESSION['name'] = $user['name'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>TODO-APP</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <h1>TODO-APP</h1>
    <h2>Prosta aplikacja typu TODO</h2>
</head>
<body>



<?php if (isset($user)): ?>

    <h2>Witaj <?= htmlspecialchars($user["name"]) ?>!</h2>
    <p><a href="home.php">Przejdź do swoich zadań</a></p>
    <p><a href="projects.php">Przejdź do swoich projektów</a></p>
    <p><a href="calendar.php">Przejdź do swojego kalendarza</a></p>
    <p><a href="logout.php">Wyloguj</a></p>

<?php else: ?>
    <p><a href="login.php">Logowanie</a> lub <a href="signup.html">Rejestracja</a></p>
<?php endif; ?>

</body>
</html>