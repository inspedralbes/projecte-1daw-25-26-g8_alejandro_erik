<?php
include("conexio.php");

$sql = "SELECT * FROM incidencies";
$result = $conn->query($sql);
?>

<h2>Llistat incidències</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Títol</th>
    <th>Estat</th>
    <th>Accions</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['titol']; ?></td>
    <td><?php echo $row['estat']; ?></td>
    <td>
        <a href="detall_incidencia.php?id=<?php echo $row['id']; ?>">Editar</a>
    </td>
</tr>
<?php } ?>

</table>