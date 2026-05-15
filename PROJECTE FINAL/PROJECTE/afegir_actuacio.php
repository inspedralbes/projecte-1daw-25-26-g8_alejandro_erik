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
        $missatge = '<div class="alert alert-danger shadow-sm">La descripció ha de tenir almenys 20 caràcters!</div>';
    } elseif ($temps <= 0) {
        $missatge = '<div class="alert alert-danger shadow-sm">El temps dedicat ha de ser superior a 0 minuts.</div>';
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
            $missatge = '<div class="alert alert-success shadow-sm">Actuació registrada i incidència <strong>tancada</strong> correctament!</div>';
        } else {
            $conn->prepare(
                "UPDATE INCIDENCIA SET estat='en_proces' WHERE id_incidencia=? AND estat='oberta'"
            )->execute([$id_incidencia]);
            $missatge = '<div class="alert alert-success shadow-sm">Actuació registrada correctament!</div>';
        }
    }
}

$id = intval($_GET['id'] ?? $_POST['id_incidencia'] ?? 0);

include 'cap.php';
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrar Actuació - Pedralbes</title>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    
    <div class="mb-4">
        <h1 class="fw-bold">Registrar Actuació</h1>
        <p class="text-muted">Afegeix detalls tècnics i temps dedicat a una incidència.</p>
    </div>

    <?php if ($id <= 0): ?>
        <div class="card shadow-sm border-0 p-4">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Número d'incidència:</label>
                    <input type="number" name="id" class="form-control" placeholder="Introdueix l'ID (ex: 1)" min="1">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary px-4">Carregar Incidència</button>
                    <a href="incidencies.php" class="btn btn-outline-secondary">Llistat</a>
                </div>
            </form>
        </div>

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
            <div class="alert alert-danger shadow-sm">No s'ha trobat la incidència #<?php echo $id; ?>.</div>
            <a href="afegir_actuacio.php" class="btn btn-secondary">Tornar enrere</a>
        <?php else: ?>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white fw-bold">
                    Dades de la Incidència #<?php echo $inc['id_incidencia']; ?>
                </div>
                <div class="card-body">
                    <h5 class="fw-bold text-primary"><?php echo htmlspecialchars($inc['nom_departament'] ?? 'Sense Dept.'); ?></h5>
                    <p class="mb-3"><?php echo htmlspecialchars($inc['descripcio']); ?></p>
                    <div class="d-flex gap-3 small">
                        <span><strong>Tècnic:</strong> <?php echo htmlspecialchars($inc['nom_tecnic'] ?? 'Pendent'); ?></span>
                        <span><strong>Prioritat:</strong> <span class="text-uppercase"><?php echo $inc['prioritat'] ?? '-'; ?></span></span>
                        <span><strong>Estat:</strong> 
                            <?php if ($inc['estat'] === 'tancada'): ?>
                                <span class="badge bg-secondary">Tancada</span>
                            <?php elseif ($inc['estat'] === 'en_proces'): ?>
                                <span class="badge bg-primary">En procés</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Oberta</span>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <h4 class="fw-bold mb-3">Historial d'Actuacions</h4>
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
            
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-body p-0">
                    <?php if (empty($actuacions)): ?>
                        <p class="p-3 mb-0 text-muted italic">Encara no s'ha registrat cap actuació per a aquesta incidència.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr><th>Data</th><th>Tècnic</th><th>Descripció</th><th>Temps</th><th class="text-center">Visible</th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($actuacions as $act): ?>
                                        <tr>
                                            <td class="small text-muted"><?php echo date('d/m/Y H:i', strtotime($act['data_actuacio'])); ?></td>
                                            <td class="fw-bold"><?php echo htmlspecialchars($act['nom_tecnic'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($act['descripcio']); ?></td>
                                            <td><?php echo $act['temps_dedicat']; ?> min</td>
                                            <td class="text-center"><?php echo $act['visible_usuari'] ? '✅' : '❌'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $missatge; ?>

            <?php if ($inc['estat'] !== 'tancada'): ?>
                <?php $tecnics = $conn->query("SELECT * FROM TECNIC ORDER BY nom")->fetchAll(); ?>

                <div class="card border-primary shadow-sm">
                    <div class="card-header bg-primary text-white fw-bold">Nova Actuació Tècnica</div>
                    <div class="card-body p-4">
                        <form method="POST" onsubmit="return validarActuacio()">
                            <input type="hidden" name="id_incidencia" value="<?php echo $inc['id_incidencia']; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tècnic:</label>
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
                                    <label class="form-label fw-bold">Temps (minuts): <span class="text-danger">*</span></label>
                                    <input type="number" name="temps_dedicat" class="form-control" min="1" value="15">
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="visible_usuari" id="visible" checked>
                                        <label class="form-check-label" for="visible">Visible usuari</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    Descripció del treball: <span class="text-danger">*</span>
                                    <small id="comptador" class="text-muted ms-2">(mínim 20 caràcters)</small>
                                </label>
                                <textarea name="descripcio" id="descripcio" class="form-control" rows="4" placeholder="Explica què has fet per resoldre el problema..."></textarea>
                            </div>

                            <div class="bg-light p-3 rounded mb-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tancar" id="tancar">
                                            <label class="form-check-label fw-bold text-danger" for="tancar">Finalitzar i Tancar Incidència</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Data finalització:</span>
                                            <input type="date" name="data_finalitzacio" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Guardar Actuació</button>
                                <a href="incidencies.php" class="btn btn-outline-secondary">Tornar al llistat</a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-secondary border-0 shadow-sm">Aquesta incidència ja està tancada. No s'hi poden afegir més actuacions.</div>
                <a href="incidencies.php" class="btn btn-secondary">Tornar al llistat</a>
            <?php endif; ?>

        <?php endif; ?>
    <?php endif; ?>

</div>

<script>
var desc = document.getElementById('descripcio');
if (desc) {
    desc.addEventListener('input', function () {
        var len = this.value.length;
        var comp = document.getElementById('comptador');
        comp.textContent = len + ' caràcters';
        if (len < 20) comp.className = 'text-danger ms-2';
        else comp.className = 'text-success ms-2';
    });
}
function validarActuacio() {
    var d = document.getElementById('descripcio').value.trim();
    if (d.length < 20) {
        alert('La descripció és massa curta! Explica millor l\'actuació (mínim 20 caràcters).');
        return false;
    }
    return true;
}
</script>

<?php include 'peu.php'; ?>
</body>
</html>