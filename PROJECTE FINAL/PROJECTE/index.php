<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Incidències</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
        }
        h1 {
            margin-top: 50px;
        }
        .menu {
            margin-top: 40px;
        }
        .menu a {
            display: block;
            margin: 10px auto;
            padding: 15px;
            width: 250px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Benvingut al sistema d'incidències</h1>
    <p>Selecciona una opció:</p>

    <div class="menu">
        <a href="incidencies.php">Veure incidències</a>
        <a href="crear_incidencies.php">Crear incidència</a>
        <a href="afegir_actuacio.php">Afegir actuació</a>
    </div>

</body>
</html>