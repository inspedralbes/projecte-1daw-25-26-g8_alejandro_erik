<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestió d'Incidències - Institut Pedralbes</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
    crossorigin="anonymous">

    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .navbar {
            background-color: #003366 !important;
        }

        .navbar a,
        .navbar-brand {
            color: white !important;
        }

        .navbar .nav-link:hover {
            color: #adc8ff !important;
        }

        .page-title {
            color: #003366;
            border-bottom: 2px solid #003366;
            padding-bottom: 8px;
            margin-bottom: 20px;
        }

        .peu {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 12px;
            margin-top: 40px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">

            <a class="navbar-brand" href="index.php">
                Institut Pedralbes
            </a>

            <button class="navbar-toggler bg-light" 
                    type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navMenu">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="crear_incidencies.php">
                            Nova Incidència
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="detall_incidencia.php">
                            Modificar
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="afegir_actuacio.php">
                            Actuació
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        <h1 class="page-title">
            Gestió d'Incidències
        </h1>

        <p>
            Gestor de les incidencies informàtiques de l'Institut Pedralbes.

    </div>
    

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    
</body>
</