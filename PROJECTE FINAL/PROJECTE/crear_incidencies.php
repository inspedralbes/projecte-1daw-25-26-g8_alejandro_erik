<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

    <div class="container bg-white p-4 shadow rounded" style="max-width: 500px;">
        <h2 class="text-center mb-4">Nova Incidència</h2>

        <form method="POST" id="meuForm">
            <div class="mb-3">
                <label class="form-label">Títol:</label>
                <input type="text" name="titol" id="titol" class="form-control" placeholder="Què passa?">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Descripció detallada:</label>
                <textarea name="descripcio" id="desc" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prioritat:</label>
                <select name="prioritat" class="form-select">
                    <option value="Baixa">Baixa</option>
                    <option value="Mitja">Mitja</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Registrar Incidència</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $titol = htmlspecialchars($_POST["titol"]);
            echo "<div class='alert alert-success mt-3'>S'ha registrat: <strong>$titol</strong></div>";
        }
        ?>

        <div class="text-center mt-3">
            <a href="index.php" class="text-muted">Cancel·lar i tornar</a>
        </div>
    </div>

    <script>
        document.getElementById('meuForm').onsubmit = function(e) {
            let t = document.getElementById('titol').value;
            if(t.length < 5) {
                e.preventDefault();
                alert("El títol és massa curt!");
            }
        };
    </script>

</body>
</html>