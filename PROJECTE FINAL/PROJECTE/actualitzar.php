<?php
include("conexio.php");

$id = $_POST['id'];
$prioritat = $_POST['prioritat'];
$tipus = $_POST['tipus'];
$tecnic = $_POST['tecnic'];

$sql = "UPDATE incidencies 
        SET prioritat='$prioritat', tipus='$tipus', tecnic='$tecnic'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Actualitzat correctament";
    echo "<br><a href='incidencies.php'>Tornar</a>";
} else {
    echo "Error: " . $conn->error;
}
?>