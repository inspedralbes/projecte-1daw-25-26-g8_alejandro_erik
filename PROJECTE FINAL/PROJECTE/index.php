<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

        .menu a {
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body>

    <div class="container">
        
        <h1 class="fw-bold text-dark">Benvingut al sistema d'incidències</h1>
        <p class="lead text-muted">Selecciona una opció:</p>

        <div class="menu">
            <a href="incidencies.php">Veure incidències</a>
            <a href="crear_incidencies.php">Crear incidència</a>
            <a href="afegir_actuacio.php">Afegir actuació</a>
        </div>

    </div>

</body>
</html>