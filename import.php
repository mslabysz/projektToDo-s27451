<?php
session_start();
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import-btn'])) {
    $file = $_FILES['import-file']['tmp_name'];


    if (($handle = fopen($file, "r")) !== false) {
        // Pomiń nagłówki
        fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $task_name = $data[0];
            $task_created_at = $data[1];
            $due_date = $data[2];
            $task_priority = $data[3];
            $notes = $data[4];
            $project = $data[5];

            // Sprawdzanie czy projekt istnieje
            $selectProject = "SELECT `id` FROM `projects` WHERE `id` = '$project'";
            $resultProject = $mysqli->query($selectProject);

            if ($resultProject !== false) {
                if ($resultProject->num_rows > 0) {
                    // Projekt o podanym project_id istnieje, insert z projektem
                    $insert = "INSERT INTO `todolist` (`user_id`, `tasks`, `created_at`, `due_date`, `priority`, `notes`, `project_id`) 
                        VALUES ('$user_id', '$task_name', '$task_created_at', '$due_date', '$task_priority', '$notes', '$project')";
                } else {
                    // Projekt o podanym project_id nie istnieje, insert bez projektu
                    $insert = "INSERT INTO `todolist` (`user_id`, `tasks`, `created_at`, `due_date`, `priority`, `notes`) 
                        VALUES ('$user_id', '$task_name', '$task_created_at', '$due_date', '$task_priority', '$notes')";
                }

                if ($mysqli->query($insert) === false) {
                    echo "Błąd podczas importowania rekordu: " . $mysqli->error;
                }
            } else {
                echo "Błąd podczas sprawdzania projektu: " . $mysqli->error;
            }
        }
        fclose($handle);
    }

    header('Location: home.php');
    exit();
}
?>
