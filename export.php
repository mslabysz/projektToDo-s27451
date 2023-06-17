<?php
// export.php

session_start();
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

$mysqli = require __DIR__ . "/database.php";

// Pobierz zadania użytkownika
$select = "SELECT * FROM `todolist` WHERE `user_id` = '$user_id' AND `completed` = 0";
$result = $mysqli->query($select);

if ($result && $result->num_rows > 0) {
    // Tworzenie pliku CSV
    $file = fopen('todo_list.csv', 'w');

    // Nagłówki kolumn w pliku CSV
    $headers = array('Zadanie', 'Data dodania', 'Termin wykonania', 'Priorytet');
    fputcsv($file, $headers);

    // Zapisywanie danych z bazy do pliku CSV
    while ($row = $result->fetch_assoc()) {
        $task_name = $row['tasks'];
        $task_created_at = $row['created_at'];
        $due_date = $row['due_date'];
        $task_priority = $row['priority'];

        $data = array($task_name, $task_created_at, $due_date, $task_priority);
        fputcsv($file, $data);
    }

    // Zamykanie pliku
    fclose($file);

    // Pobieranie pliku CSV
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="todo_list.csv";');
    readfile('todo_list.csv');
    exit();
} else {
    echo "Brak zadań do wyeksportowania.";
}

