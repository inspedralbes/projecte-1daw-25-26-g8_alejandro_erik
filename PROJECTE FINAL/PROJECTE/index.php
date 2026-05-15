<?php include 'cap.php'; ?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .main-content { padding-top: 30px; padding-bottom: 50px; }
    </style>
</head>
<body>
<div class="container main-content">
    <div class="mb-4">
        <p class="text-muted lead">Benvingut, selecciona una opció per començar:</p>
    </div>
    <div class="row g-4">

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">Nova Incidència</h5>
                    <p class="card-text flex-grow-1">Registra una nova incidència informàtica al sistema.</p>
                    <a href="crear_incidencies.php" class="btn btn-primary mt-3">Anar</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold">Llistat d'Incidències</h5>
                    <p class="card-text flex-grow-1">Veure totes les incidències registrades i la seva prioritat.</p>
                    <a href="incidencies.php" class="btn btn-primary mt-3">Anar</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">Modificar Incidència</h5>
                    <p class="card-text flex-grow-1">Assignar tècnic i prioritat a incidències pendents.</p>
                    <a href="detall_incidencia.php" class="btn btn-warning mt-3">Anar</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-warning">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">Registrar Actuació</h5>
                    <p class="card-text flex-grow-1">Afegir una actuació tècnica a una incidència existent.</p>
                    <a href="afegir_actuacio.php" class="btn btn-warning mt-3">Anar</a>
                </div>
            </div>
        </div>

        
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-info">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-dark">📋 Historial MongoDB</h5>
                    <p class="card-text flex-grow-1">Veure el registre de totes les accions realitzades al sistema.</p>
                    <a href="historial_mongo.php" class="btn btn-info mt-3">Anar</a>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'peu.php'; ?>