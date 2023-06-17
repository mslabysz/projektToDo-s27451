<?php
session_start();
$user_id = $_POST['user_id'];

$mysqli = require __DIR__ . "/database.php";

$select = "SELECT id, tasks AS title, due_date AS start FROM todolist WHERE user_id = '$user_id' AND completed = 0";
$result = $mysqli->query($select);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event = [
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start']
        ];
        $events[] = $event;
    }
}

echo json_encode($events);
?>

