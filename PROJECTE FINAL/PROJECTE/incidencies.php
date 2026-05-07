<?php
include 'conexio.php';
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$sql = "SELECT
            i.id_incidencia,
            i.descripcio,
            i.estat,
            i.prioritat,
            d.nom AS departament,
            t.nom AS tecnic

        FROM INCIDENCIA i

        INNER JOIN DEPARTAMENT d
            ON i.id_departament = d.id_departament

        LEFT JOIN TECNIC t
            ON i.id_tecnic = t.id_tecnic

        ORDER BY i.data_creacio DESC";

$resultat = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Llistat incidències</title>
</head>
<body>

<h1>Llistat incidències</h1>

<table border="1">

<tr>
    <th>ID</th>
    <th>Departament</th>
    <th>Descripció</th>
    <th>Estat</th>
    <th>Prioritat</th>
    <th>Tècnic</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($resultat)) { ?>

<tr>

    <td><?= $fila['id_incidencia'] ?></td>
    <td><?= $fila['departament'] ?></td>
    <td><?= $fila['descripcio'] ?></td>
    <td><?= $fila['estat'] ?></td>
    <td><?= $fila['prioritat'] ?></td>
    <td><?= $fila['tecnic'] ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>