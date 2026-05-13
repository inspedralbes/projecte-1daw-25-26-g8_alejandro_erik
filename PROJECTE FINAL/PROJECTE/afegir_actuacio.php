<?php
include 'conexio.php';

$missatge = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_incidencia = intval($_POST['id_incidencia']);
    $id_tecnic     = intval($_POST['id_tecnic']) ?: null;
    $descripcio    = trim($_POST['descripcio'] ?? '');
    $temps         = intval($_POST['temps_dedicat'] ?? 0);
    $visible       = isset($_POST['visible_usuari']) ? 1 : 0;
    $tancar        = isset($_POST['tancar']);
    $data_final    = trim($_POST['data_finalitzacio'] ?? '');

    if (strlen($descripcio) < 20) {
        $missatge = '<div class="alert alert-danger">La descripció ha de tenir almenys 20 caràcters! (ara en tens ' . strlen($descripcio) . ')</div>';
    } elseif ($temps <= 0) {
        $missatge = '<div class="alert alert-danger">El temps dedicat ha de ser superior a 0 minuts.</div>';
    } else {
        // Inserir actuació
        $stmt = $conn->prepare(
            "INSERT INTO ACTUACIO (id_incidencia, id_tecnic, descripcio, temps_dedicat, visible_usuari)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$id_incidencia, $id_tecnic, $descripcio, $temps, $visible]);

        if ($tancar) {
            $df = $data_final ?: date('Y-m-d H:i:s');
            $conn->prepare(
                "UPDATE INCIDENCIA SET estat='tancada', data_finalitzacio=? WHERE id_incidencia=?"
            )->execute([$df, $id_incidencia]);
            $missatge = '<div class="alert alert-success">Actuació registrada i incidència marcada com a <strong>tancada</strong>!</div>';
        } else {
            // Passar a en_proces si estava oberta
            $conn->prepare(
                "UPDATE INCIDENCIA SET estat='en_proces' WHERE id_incidencia=? AND estat='oberta'"
            )->execute([$id_incidencia]);
            $missatge = '<div class="alert alert-success">Actuació registrada correctament!</div>';
        }
    }
}

$id = intval($_GET['id'] ?? $_POST['id_incidencia'] ?? 0);

include 'cap.php';
?>

<h1 class="page-title">Registrar Actuació</h1>

<?php if ($id <= 0): ?>
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-auto">
            <label class="form-label">Número d'incidència:</label>
            <input type="number" name="id" class="form-control" placeholder="Ex: 1" min="1">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Carregar</button>
        </div>
    </form>

<?php else:
    $stmt = $conn->prepare("
        SELECT i.*, d.nom AS nom_departament, t.nom AS nom_tecnic
        FROM INCIDENCIA i
        LEFT JOIN DEPARTAMENT d ON i.id_departament = d.id_departament
        LEFT JOIN TECNIC t      ON i.id_tecnic      = t.id_tecnic
        WHERE i.id_incidencia = ?
    ");
    $stmt->execute([$id]);
    $inc = $stmt->fetch();
?>

    <?php if (!$inc): ?>
        <div class="alert alert-danger">No s'ha trobat la incidència #<?php echo $id; ?>.</div>
        <a href="afegir_actuacio.php" class="btn btn-secondary">Tornar</a>
    <?php else: ?>

        <div class="card mb-3">
            <div class="card-header fw-bold">
                Incidència #<?php echo $inc['id_incidencia']; ?> &mdash; <?php echo htmlspecialchars($inc['nom_departament'] ?? '-'); ?>
            </div>
            <div class="card-body">
                <p><?php echo htmlspecialchars($inc['descripcio']); ?></p>
                <p>
                    <strong>Tècnic:</strong> <?php echo htmlspecialchars($inc['nom_tecnic'] ?? 'Sense assignar'); ?> &nbsp;|&nbsp;
                    <strong>Prioritat:</strong> <?php echo $inc['prioritat'] ?? '-'; ?> &nbsp;|&nbsp;
                    <strong>Estat:</strong>
                    <?php if ($inc['estat'] === 'tancada'): ?>
                        <span class="badge bg-secondary">Tancada</span>
                    <?php elseif ($inc['estat'] === 'en_proces'): ?>
                        <span class="badge bg-primary">En procés</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Oberta</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <h4>Actuacions fins ara:</h4>
        <?php
        $stmt2 = $conn->prepare("
            SELECT a.*, t.nom AS nom_tecnic
            FROM ACTUACIO a
            LEFT JOIN TECNIC t ON a.id_tecnic = t.id_tecnic
            WHERE a.id_incidencia = ?
            ORDER BY a.data_actuacio ASC
        ");
        $stmt2->execute([$id]);
        $actuacions = $stmt2->fetchAll();
        ?>
        <?php if (empty($actuacions)): ?>
            <p class="text-muted">Encara no hi ha actuacions.</p>
        <?php else: ?>
            <table class="table table-sm table-bordered mb-4">
                <thead class="table-secondary">
                    <tr><th>Data</th><th>Tècnic</th><th>Descripció</th><th>Temps</th><th>Visible</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($actuacions as $act): ?>
                        <tr>
                            <td><?php echo $act['data_actuacio']; ?></td>
                            <td><?php echo htmlspecialchars($act['nom_tecnic'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($act['descripcio']); ?></td>
                            <td><?php echo $act['temps_dedicat']; ?> min</td>
                            <td><?php echo $act['visible_usuari'] ? 'Sí' : 'No'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php echo $missatge; ?>

        <?php if ($inc['estat'] !== 'tancada'): ?>
            <?php $tecnics = $conn->query("SELECT * FROM TECNIC ORDER BY nom")->fetchAll(); ?>

            <h4>Nova Actuació</h4>
            <form method="POST" onsubmit="return validarActuacio()">
                <input type="hidden" name="id_incidencia" value="<?php echo $inc['id_incidencia']; ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tècnic que fa l'actuació:</label>
                        <select name="id_tecnic" class="form-select">
                            <option value="">-- Selecciona tècnic --</option>
                            <?php foreach ($tecnics as $tec): ?>
                                <option value="<?php echo $tec['id_tecnic']; ?>"
                                    <?php echo $inc['id_tecnic'] == $tec['id_tecnic'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($tec['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Temps dedicat (minuts): <span class="text-danger">*</span></label>
                        <input type="number" name="temps_dedicat" class="form-control" min="1" value="0">
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="visible_usuari" id="visible" checked>
                            <label class="form-check-label" for="visible">Visible per l'usuari</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Descripció (mínim 20 caràcters): <span class="text-danger">*</span>
                        &nbsp;<small id="comptador" class="text-muted">0 caràcters</small>
                    </label>
                    <textarea name="descripcio" id="descripcio" class="form-control" rows="4"></textarea>
                </div>

                <hr>
                <div class="row align-items-end">
                    <div class="col-auto">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tancar" id="tancar">
                            <label class="form-check-label fw-bold" for="tancar">Marcar incidència com a finalitzada</label>
                        </div>
                    </div>
                    <div class="col-auto">
                        <label class="form-label">Data finalització:</label>
                        <input type="date" name="data_finalitzacio" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Registrar Actuació</button>
                <a href="incidencies.php" class="btn btn-secondary">Tornar al llistat</a>
            </form>

        <?php else: ?>
            <div class="alert alert-secondary">Aquesta incidència ja està tancada. No es poden afegir més actuacions.</div>
            <a href="incidencies.php" class="btn btn-secondary">Tornar al llistat</a>
        <?php endif; ?>

    <?php endif; ?>
<?php endif; ?>

<script>
var desc = document.getElementById('descripcio');
if (desc) {
    desc.addEventListener('input', function () {
        document.getElementById('comptador').textContent = this.value.length + ' caràcters';
    });
}
function validarActuacio() {
    var d = document.getElementById('descripcio').value.trim();
    if (d.length < 20) {
        alert('La descripció ha de tenir almenys 20 caràcters! (ara en tens ' + d.length + ')');
        return false;
    }
    return true;
}
</script>

<?php include 'peu.php'; ?>