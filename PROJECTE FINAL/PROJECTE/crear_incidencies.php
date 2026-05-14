<?php
include 'conexio.php';

$missatge = '';
$id_nova  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_departament = intval($_POST['id_departament'] ?? 0);
    $descripcio     = trim($_POST['descripcio'] ?? '');

    if ($id_departament <= 0 || empty($descripcio)) {
        $missatge = '<div class="alert alert-danger shadow-sm">Tots els camps són obligatoris.</div>';
    } else {
        // Inserim la incidència. Nota: 'prioritat' es queda com a NULL o segons defecte de BD fins que un tècnic la modifiqui.
        $stmt = $conn->prepare(
            "INSERT INTO INCIDENCIA (id_departament, descripcio, estat) VALUES (?, ?, 'oberta')"
        );
        $stmt->execute([$id_departament, $descripcio]);
        $id_nova  = $conn->lastInsertId();
        $missatge = '<div class="alert alert-success shadow-sm">
            <h4 class="alert-heading">Incidència registrada!</h4>
            <p>S\'ha creat correctament amb el codi: <strong>#' . $id_nova . '</strong>.</p>
            <hr>
            <p class="mb-0">Guarda aquest número per fer el seguiment de la teva petició.</p>
        </div>';
    }
}

// Carreguem departaments per al select
$conn->exec("set names utf8");
$departaments = $conn->query("SELECT * FROM DEPARTAMENT ORDER BY nom")->fetchAll();

include 'cap.php';
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Nova Incidència - Pedralbes</title>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="mb-4">
                <h1 class="fw-bold">Nova Incidència</h1>
                <p class="text-muted">Data actual: <?php echo date('d/m/Y'); ?></p>
            </div>

            <?php echo $missatge; ?>

            <div class="card shadow-sm border-0 rounded-3 mt-3">
                <div class="card-body p-4">
                    
                    <?php if (!$id_nova): ?>
                        <p class="mb-4">Omple les dades següents per obrir un tiquet de suport tècnic:</p>
                        
                        <form method="POST" onsubmit="return validarForm()">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Departament: <span class="text-danger">*</span></label>
                                <select name="id_departament" id="id_departament" class="form-select form-select-lg">
                                    <option value="">-- Selecciona departament --</option>
                                    <?php foreach ($departaments as $dep): ?>
                                        <option value="<?php echo $dep['id_departament']; ?>">
                                            <?php echo htmlspecialchars($dep['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Descripció del problema: <span class="text-danger">*</span></label>
                                <textarea name="descripcio" id="descripcio" class="form-control" rows="5"
                                          placeholder="Explica què ha passat amb detall..."></textarea>
                                <div class="form-text">Sigues el més específic possible (codis d'error, aula, etc.).</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Registrar Incidència</button>
                                <a href="index.php" class="btn btn-link text-muted">Cancel·lar i tornar</a>
                            </div>
                        </form>

                    <?php else: ?>
                        <div class="text-center py-3">
                            <div class="d-grid gap-2">
                                <a href="incidencies.php" class="btn btn-primary btn-lg">Anar al llistat</a>
                                <a href="index.php" class="btn btn-outline-secondary">Tornar al menú d'inici</a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
function validarForm() {
    var dep  = document.getElementById('id_departament').value;
    var desc = document.getElementById('descripcio').value.trim();
    
    if (!dep) {
        alert('Per favor, selecciona un departament.');
        return false;
    }
    if (desc.length < 10) {
        alert("La descripció és massa curta. Explica una mica més el problema.");
        return false;
    }
    return true;
}
</script>

<?php include 'peu.php'; ?>
</body>
</html>