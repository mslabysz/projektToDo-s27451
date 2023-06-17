<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mysqli = require __DIR__ . "/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import-btn'])) {
    if ($_FILES['import-file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['import-file']['tmp_name'];

        // Otwórz plik CSV
        $handle = fopen($file, "r");
        if ($handle !== false) {
            // Przejdź przez każdą linię pliku
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $tasks = $data[0];
                $priority = $data[1];
                $due_date = $data[2];

                // Wstaw dane do bazy danych
                $insert = "INSERT INTO `todolist` (`user_id`, `tasks`, `priority`, `due_date`, `completed`, `created_at`, `updated_at`)
                           VALUES ('{$_SESSION['user_id']}', '$tasks', '$priority', '$due_date', 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                $query = $mysqli->query($insert);

                if (!$query) {
                    echo "<script>alert('Coś poszło nie tak podczas importowania!');</script>";
                    break;
                }
            }

            fclose($handle);
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Nie udało się otworzyć pliku CSV!');</script>";
        }
    } else {
        echo "<script>alert('Wystąpił błąd podczas przesyłania pliku!');</script>";
    }
}
?>


