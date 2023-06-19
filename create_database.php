<?php
$servername = "localhost";
$username = "root";
$password = "";

// Połączenie z serwerem MySQL
$mysqli = new mysqli($servername, $username, $password);

// Sprawdzenie połączenia
if ($mysqli->connect_error) {
    die("Błąd połączenia: " . $mysqli->connect_error);
}

// Tworzenie bazy danych
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS logindb";
if ($mysqli->query($createDatabaseQuery) === TRUE) {
    echo "Baza danych została utworzona pomyślnie. ";
} else {
    echo "Błąd podczas tworzenia bazy danych: " . $mysqli->error;
}

// Użycie bazy danych
$mysqli->select_db("logindb");

// Importowanie struktury tabel i danych
$importSql = file_get_contents("logindb.sql");

if ($mysqli->multi_query($importSql) === TRUE) {
    echo "Struktura tabel i dane zostały zaimportowane pomyślnie.";
    header('Location: index.php');
} else {
    echo "Błąd podczas importowania struktury tabel i danych: " . $mysqli->error;
}

// Zamknięcie połączenia z bazą danych
$mysqli->close();

?>

