<?php
include("conexio.php");

$id = $_GET['id'];

$sql = "SELECT * FROM incidencies WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h2>Editar incidència</h2>

<form action="actualitzar_incidencia.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    Prioritat:
    <input type="text" name="prioritat" value="<?php echo $row['prioritat']; ?>"><br>

    Tipus:
    <input type="text" name="tipus" value="<?php echo $row['tipus']; ?>"><br>

    Tècnic:
    <input type="text" name="tecnic" value="<?php echo $row['tecnic']; ?>"><br>

    <button type="submit">Guardar</button>
</form>