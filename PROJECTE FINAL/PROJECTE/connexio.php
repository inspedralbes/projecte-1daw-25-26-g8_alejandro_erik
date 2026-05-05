<?php
$host = "db";          // nombre del servicio en docker-compose
$user = "root";       
$password = "root";   
$database = "incidencies_db";

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Comprobar conexión
if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}

// Opcional: para evitar problemas con acentos
$conn->set_charset("utf8");
?>