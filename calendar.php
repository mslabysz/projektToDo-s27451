<?php
session_start();
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

$mysqli = require __DIR__ . "/database.php";
?>
<h1>Kalendarz z twoimi zadaniami:</h1>
<div id="calendar"></div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: {
                url: 'events.php',
                type: 'POST',
                data: {
                    user_id: <?php echo $user_id; ?> // przekazanie identyfikatora użytkownika
                },
                error: function () {
                    alert('Wystąpił błąd podczas pobierania wydarzeń!');
                }
            }
        });
    });
</script>

<form method="post" action="home.php">
    <button type="submit" name="home-btn">Przejdź do zadań</button>
</form>
<form method="post" action="projects.php">
    <button type="submit" name="projects-btn">Przejdź do projektów</button>
</form>

