<?php

if (empty($_POST["name"])) {
    die("Wymagana nazwa.");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Wymagany poprawny email.");
}

if (strlen($_POST["password"]) < 8) {
    die("Hasło musi mieć przynajmniej 8 znaków.");
}

if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
    die("Hasło musi mieć przynajmniej jedną literę.");
}

if ( ! preg_match("/[0-9]/", $_POST["password"])) {
    die("Hasło musi mieć przynajmniej jedną cyfrę.");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Hasła muszą być takie same.");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
    $_POST["name"],
    $_POST["email"],
    $password_hash);

if ($stmt->execute()) {

    header("Location: signup-success.html");
    exit;

} else {

    if ($mysqli->errno === 1062) {
        die("email jest już używany");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}