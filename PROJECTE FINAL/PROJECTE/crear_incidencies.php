<?php
include 'conexio.php';

$missatge = '';
$id_nova  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_departament = intval($_POST['id_departament'] ?? 0);
    $descripcio     = trim($_POST['descripcio'] ?? '');

    if ($id_departament <= 0 || empty($descripcio)) {
        $missatge = '<div class="alert alert-danger">Tots els camps són obligatoris.</div>';
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO INCIDENCIA (id_departament, descripcio, estat) VALUES (?, ?, 'oberta')"
        );
        $stmt->execute([$id_departament, $descripcio]);
        $id_nova  = $conn->lastInsertId();
        $missatge = '<div class="alert alert-success">
            Incidència registrada correctament!<br>
            El teu codi és: <strong>' . $id_nova . '</strong>. Guarda\'l per consultar l\'estat.
        </div>';
    }
}

$departaments = $conn->query("SELECT * FROM DEPARTAMENT ORDER BY nom")->fetchAll();

include 'includes/capcalera.php';
?>

<h1 class="page-title">Nova Incidència</h1>
<p>Omple el formulari per registrar una nova incidència. La data s'agafa automàticament (<?php echo date('d/m/Y'); ?>).</p>

<?php echo $missatge; ?>

<?php if (!$id_nova): ?>
<form method="POST" onsubmit="return validarForm()">
    <div class="mb-3">
        <label class="form-label">Departament: <span class="text-danger">*</span></label>
        <select name="id_departament" id="id_departament" class="form-select">
            <option value="">-- Selecciona el teu departament --</option>
            <?php foreach ($departaments as $dep): ?>
                <option value="<?php echo $dep['id_departament']; ?>">
                    <?php echo htmlspecialchars($dep['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Descripció de la incidència: <span class="text-danger">*</span></label>
        <textarea name="descripcio" id="descripcio" class="form-control" rows="4"
                  placeholder="Descriu el problema de forma clara..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Registrar Incidència</button>
    <a href="index.php" class="btn btn-secondary">Cancel·lar</a>
</form>
<?php else: ?>
    <a href="index.php" class="btn btn-primary">Tornar a l'inici</a>
    <a href="estat_incidencia.php?id=<?php echo $id_nova; ?>" class="btn btn-outline-primary">
        Veure estat de la incidència #<?php echo $id_nova; ?>
    </a>
<?php endif; ?>

<script>
function validarForm() {
    var dep  = document.getElementById('id_departament').value;
    var desc = document.getElementById('descripcio').value.trim();
    if (!dep) {
        alert('Has de seleccionar el departament!');
        return false;
    }
    if (!desc) {
        alert("Has d'introduir una descripció!");
        return false;
    }
    return true;
}
</script>

<?php include 'includes/peu.php'; ?>