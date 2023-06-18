<?php
// Połączenie z bazą danych
$mysqli = new mysqli('localhost', 'root', '', 'logindb');
if ($mysqli->connect_errno) {
    echo "Błąd połączenia z bazą danych: " . $mysqli->connect_error;
    exit();
}

// Dodawanie nowego projektu
if (isset($_POST['project_name']) && isset($_POST['project_description'])) {
    $projectName = $_POST['project_name'];
    $projectDescription = $_POST['project_description'];

    // Wstawienie nowego projektu do bazy danych
    $insertProject = "INSERT INTO `projects` (`name`, `description`) VALUES ('$projectName', '$projectDescription')";
    if ($mysqli->query($insertProject)) {
        echo "Nowy projekt został dodany.";
    } else {
        echo "Błąd podczas dodawania projektu: " . $mysqli->error;
    }
}

// Usuwanie projektu
if (isset($_GET['delete_project'])) {
    $projectId = $_GET['delete_project'];

    // Usunięcie projektu z bazy danych
    $deleteProject = "DELETE FROM `projects` WHERE `id` = $projectId";
    if ($mysqli->query($deleteProject)) {
        echo "Projekt został usunięty.";
    } else {
        echo "Błąd podczas usuwania projektu: " . $mysqli->error;
    }
}

// Usuwanie zadania z projektu
if (isset($_GET['delete_task'])) {
    $taskId = $_GET['delete_task'];

    // Usunięcie zadania z bazy danych
    $deleteTask = "DELETE FROM `todolist` WHERE `id` = $taskId";
    if ($mysqli->query($deleteTask)) {
        echo "Zadanie zostało usunięte z projektu.";
    } else {
        echo "Błąd podczas usuwania zadania: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <h1>Dodaj nowy projekt:</h1>
    <meta charset="UTF-8">
    <title>Aplikacja Todo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
<form method="POST" action="">
    <label for="project_name">Nazwa projektu:</label>
    <input type="text" name="project_name" required>

    <label for="project_description">Opis projektu:</label>
    <textarea name="project_description" required></textarea>

    <input type="submit" value="Dodaj projekt">
</form>
<?php
// Wyświetlanie projektów
$selectProjects = "SELECT * FROM `projects`";
$projectsResult = $mysqli->query($selectProjects);
if ($projectsResult && $projectsResult->num_rows > 0) {
    while ($projectRow = $projectsResult->fetch_assoc()) {
        $projectId = $projectRow['id'];
        $projectName = $projectRow['name'];
        $projectDescription = $projectRow['description'];

        // Wyświetl informacje o projekcie
        echo "<h1>Projekt $projectName</h1>";
        echo "<h2>Opis: $projectDescription</h2>";

        // Usuwanie projektu
        echo "<a href=\"projects.php?delete_project=$projectId\">Usuń projekt</a>";

        // Zadania przypisane do projektu
        $selectTasks = "SELECT * FROM `todolist` WHERE `project_id` = $projectId";
        $tasksResult = $mysqli->query($selectTasks);
        if ($tasksResult && $tasksResult->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                <th>Zadanie</th>
                <th>Data dodania</th>
                <th>Termin wykonania</th>
                <th>Priorytet</th>
                <th>Notatki</th>
                <th>Akcje</th>
            </tr>";
            while ($taskRow = $tasksResult->fetch_assoc()) {
                $taskId = $taskRow['id'];
                $taskName = $taskRow['tasks'];
                $taskCreatedAt = $taskRow['created_at'];
                $taskPriority = $taskRow['priority'];
                $taskNotes = $taskRow['notes'];
                $taskDue_Date=$taskRow['due_date'];

                echo "<tr>";
                echo "<td>$taskName</td>";
                echo "<td>$taskCreatedAt</td>";
                echo "<td>$taskDue_Date</td>";
                echo "<td>$taskPriority</td>";
                echo "<td>$taskNotes</td>";
                echo "<td><a href=\"projects.php?delete_task=$taskId&project_id=$projectId\">Usuń zadanie</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Brak zadań przypisanych do tego projektu.";
        }
    }
} else {
    echo "Brak dostępnych projektów.";
}
?>
<br><br>
<form method="post" action="home.php">
    <button type="submit">Przejdź do moich zadań</button>
</form>
<form method="post" action="logout.php">
    <button type="submit" name="logout-btn">Wyloguj</button>
</form>
</body>
</html>

