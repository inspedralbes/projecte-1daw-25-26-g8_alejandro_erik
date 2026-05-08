<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Incidències - Inici</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; text-align: center; font-family: Arial, sans-serif; }
        .container { margin-top: 60px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 600px; }
        h1 { margin-bottom: 30px; font-weight: bold; color: #333; }
       
        .menu a {
            display: block; margin: 15px auto; padding: 15px; width: 280px;
            text-decoration: none; background-color: #007BFF; color: white;
            border-radius: 8px; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .menu a:hover { background-color: #0056b3; transform: scale(1.02); }
    </style>
</head>
<body>

    <div class="container">
        <h1>Institut PEDRALBES</h1>
        <p class="text-muted">Benvingut, selecciona una acció:</p>

        <div class="menu">
            <a href="incidencies.php">Llistat d'incidències</a>
            <a href="crear_incidencies.php">Registrar nova incidència</a>
            <a href="afegir_actuacio.php">Afegir actuació tècnica</a>
        </div>
    </div>

</body>
</html>