<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>TODO-APP</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>

<h1>TODO-APP</h1>

<?php if (isset($user)): ?>

    <p>Witaj <?= htmlspecialchars($user["name"]) ?>!</p>

    <p><a href="logout.php">Wyloguj</a></p>

<?php else: ?>

    <p><a href="login.php">Logowanie</a> lub <a href="signup.html">Rejestracja</a></p>

<?php endif; ?>

</body>
</html>