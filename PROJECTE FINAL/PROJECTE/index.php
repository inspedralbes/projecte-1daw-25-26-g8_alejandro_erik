<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <h2>Formulari Incidencies</h2>

    <form method="post">
        Nombre: <input type="text" name="name"><br>
        correo electronic: <input type="text" name="email"><br>
        <input type="submit">
    </form>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    echo "<h3>Hola $name</h3>";
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>