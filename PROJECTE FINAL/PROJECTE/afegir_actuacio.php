<!DOCTYPE html>
<html>
<head>
    <title>Nova incidència</title>
</head>
<body>

<h2>Crear incidència</h2>

<form action="crear_incidencies.php" method="POST">
    Títol: <input type="text" name="titol" required><br>
    Descripció: <textarea name="descripcio" required></textarea><br>
    <button type="submit">Enviar</button>
</form>

</body>
</html>