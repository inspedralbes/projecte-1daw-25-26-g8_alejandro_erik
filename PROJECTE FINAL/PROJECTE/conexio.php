<?php
$local=true;

if ($local) {
        $host = "db";          
        $user = "usuari";       
        $password = "usuari1234";   
        $database = "incidencies";
} else {
        $host = "localhost";          
        $user = "a22alemanrey_Incidencies";       
        $password = "vPC43a3oM%v}q;kW";   
        $database = "a22alemanrey_Incidencies";
}

$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}


$conn->set_charset("utf8");
?>