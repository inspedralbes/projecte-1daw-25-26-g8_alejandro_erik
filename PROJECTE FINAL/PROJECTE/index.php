<?php include 'includes/cap.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="page-title">Institut Pedralbes &mdash; Sistema de Gestió d'Incidències</h1>
<p class="text-muted">Benvingut. Selecciona una opció:</p>

<div class="row mt-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">📝 Nova Incidència</h5>
                <p class="card-text">Registra una nova incidència informàtica.</p>
                <a href="crear_incidencies.php" class="btn btn-primary">Anar</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">📋 Llistat d'Incidències</h5>
                <p class="card-text">Veure totes les incidències registrades, ordenades per prioritat.</p>
                <a href="incidencies.php" class="btn btn-primary">Anar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">✏️ Modificar Incidència</h5>
                <p class="card-text">Assignar tècnic i prioritat a incidències no resoltes.</p>
                <a href="detall_incidencia.php" class="btn btn-warning">Anar</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">🔧 Registrar Actuació</h5>
                <p class="card-text">Afegir una actuació tècnica a una incidència existent.</p>
                <a href="afegir_actuacio.php" class="btn btn-warning">Anar</a>
            </div>
        </div>
    </div>
    <script> src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'includes/peu.php'; ?>