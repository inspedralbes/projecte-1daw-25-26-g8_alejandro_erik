<?php
include 'conexio.php';

$id = $_POST['id'];

$sql = "UPDATE INCIDENCIA
        SET estat='tancada',
            data_finalitzacio = NOW()
        WHERE id_incidencia=$id";

if (mysqli_query($conn, $sql)) {

    echo "Incidència tancada";

} else {

    echo mysqli_error($conn);
}
?>