<?php
$local = true;

if ($local == true) {
    $host     = "db";
    $user     = "usuari";
    $password = "usuari1234";
    $database = "incidencies";
} else {
    $host     = "localhost";
    $user     = "a22alemanrey_incidencies_ea";
    $password = "vPC43a3oM%v}q;kW";
    $database = "a22alemanrey_Incidencies";
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='color:red;font-family:Arial;padding:20px'>
        <h3>Error de connexió a la base de dades</h3>
        <p>" . $e->getMessage() . "</p>
    </div>");
}
?>