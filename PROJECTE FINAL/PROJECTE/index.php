<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <h2>Formulari Incidencies</h2>

    <form method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    echo "<h3>Hola $name</h3>";
}
?>

</body>
</html>