<?php
include 'conexio.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_departament = $_POST['id_departament'];
    $descripcio = $_POST['descripcio'];

    $sql = "INSERT INTO INCIDENCIA (
                id_departament,
                descripcio
            )
            VALUES (
                '$id_departament',
                '$descripcio'
            )";

    if (mysqli_query($conn, $sql)) {

        $id = mysqli_insert_id($conn);

        echo "Incidència creada correctament.<br>";
        echo "ID incidència: " . $id;

    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>