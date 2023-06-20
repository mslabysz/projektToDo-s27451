<?php
$host="szuflandia.pjwstk.edu.pl";
$dbname="s27451";
$username="s27451";
$password="Mak.Slab";

$mysqli=new mysqli($host,$username,$password,$dbname);

if($mysqli->connect_errno){
    die("Błąd połączenia: ".$mysqli->connect_error);
}
return $mysqli;
$mysqli->query("SET time_zone = 'Europe/Warsaw'"); //Time zone do daty dodania zadania
