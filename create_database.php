<?php
$host="szuflandia.pjwstk.edu.pl";
$dbname="s27451";
$username="s27451";
$password="Mak.Slab";

$mysqli=new mysqli($host,$username,$password,$dbname);

if ($mysqli->connect_error) {
    die("Błąd połączenia: " . $mysqli->connect_error);
}

// Tworzenie bazy danych jeśli nie istnieje
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS s27451";
if ($mysqli->query($createDatabaseQuery) === TRUE) {
    echo "Baza danych została utworzona pomyślnie. ";
} else {
    echo "Błąd podczas tworzenia bazy danych: " . $mysqli->error;
}

// Użycie bazy ze ścieżki
$mysqli->select_db("logindb");

// Importowanie struktury tabel i danych
$importSql = file_get_contents("logindb.sql");

if ($mysqli->multi_query($importSql) === TRUE) {
    echo "Struktura tabel i dane zostały zaimportowane pomyślnie.";
    header('Location: index.php');
} else {
    echo "Błąd podczas importowania struktury tabel i danych: " . $mysqli->error;
}

$mysqli->close();

?>

