<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Afegir Actuació - Sistema TIC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; font-family: Arial, sans-serif; }
        .container { margin-top: 60px; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); max-width: 500px; }
        h2 { font-weight: bold; color: #333; margin-bottom: 25px; text-align: center; }
        
        .btn-enviar {
            background-color: #007BFF; color: white; border: none; padding: 12px;
            width: 100%; border-radius: 5px; font-size: 16px; transition: 0.3s;
        }
        .btn-enviar:hover { background-color: #0056b3; cursor: pointer; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Afegir Actuació Tècnica</h2>

        <form action="incidencies.php" method="POST" id="formActuacio">
            
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">ID de l'Incidència:</label>
                <input type="text" name="id_incidencia" class="form-control" value="101" readonly>
                <div class="form-text">Estàs afegint informació a la incidència #101.</div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Descripció del treball realitzat:</label>
                <textarea name="descripcio" id="desc" class="form-control" rows="5" placeholder="Explica què has fet per solucionar-ho..."></textarea>
            </div>

            <button type="submit" class="btn-enviar">Registrar Actuació</button>
        </form>

        <div class="text-center mt-4">
            <a href="incidencies.php" class="text-decoration-none text-muted">← Tornar al llistat</a>
        </div>
    </div>

    <script>
        document.getElementById('formActuacio').onsubmit = function(e) {
            var text = document.getElementById('desc').value;
            
            
            if(text.length < 20) {
                e.preventDefault(); 
                alert("Per favor, sigues més específic. La descripció ha de tenir almenys 20 caràcters.");
            }
        };
    </script>

</body>
</html>