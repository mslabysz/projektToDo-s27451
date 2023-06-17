<?php
$host="localhost";
$dbname="logindb";
$username="root";
$password="";

$mysqli=new mysqli($host,$username,$password,$dbname);

if($mysqli->connect_errno){
    die("Błąd połączenia: ".$mysqli->connect_error);
}
return $mysqli;
$mysqli->query("SET time_zone = 'Europe/Warsaw'");
