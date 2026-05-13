<?php
include 'conexio.php';

// Guardar canvis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id       = intval($_POST['id']);
    $prioritat = $_POST['prioritat'] ?: null;
    $id_tecnic = intval($_POST['id_tecnic']) ?: null;
    $estat     = $_POST['estat'];

    $stmt = $conn->prepare(
        "UPDATE INCIDENCIA SET prioritat=?, id_tecnic=?, estat=? WHERE id_incidencia=?"
    );
    $stmt->execute([$prioritat, $id_tecnic, $estat, $id]);
    header("Location: detall_incidencia.php?ok=1");
    exit;
}

include 'cap.php';

$ok = isset($_GET['ok']);
$id_sel = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Incidències no tancades
$incidencies = $conn->query("
    SELECT i.*, d.nom AS nom_departament, t.nom AS nom_tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTAMENT d ON i.id_departament = d.id_departament
    LEFT JOIN TECNIC t      ON i.id_tecnic      = t.id_tecnic
    WHERE i.estat != 'tancada'
    ORDER BY FIELD(i.prioritat,'alta','mitjana','baixa'), i.data_creacio ASC
")->fetchAll();

$tecnics = $conn->query("SELECT * FROM TECNIC ORDER BY nom")->fetchAll();
?>

<h1 class="page-title">Modificar Incidències</h1>
<p>Incidències no resoltes. Clica una fila per editar-la.</p>

<?php if ($ok): ?>
    <div class="alert alert-success">Incidència actualitzada correctament!</div>
<?php endif; ?>

<?php if (empty($incidencies)): ?>
    <div class="alert alert-info">No hi ha incidències obertes en aquest moment.</div>
<?php else: ?>
    <div class="table-responsive mb-4">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Departament</th><th>Data</th>
                <th>Descripció</th><th>Prioritat</th><th>Tècnic</th><th>Estat</th><th>Acció</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencies as $inc):
                $classe = match($inc['prioritat']) {
                    'alta'    => 'table-danger',
                    'mitjana' => 'table-warning',
                    'baixa'   => 'table-success',
                    default   => ''
                };
            ?>
                <tr class="<?php echo $classe; ?>">
                    <td><strong>#<?php echo $inc['id_incidencia']; ?></strong></td>
                    <td><?php echo htmlspecialchars($inc['nom_departament'] ?? '-'); ?></td>
                    <td><?php echo $inc['data_creacio']; ?></td>
                    <td><?php echo htmlspecialchars(mb_substr($inc['descripcio'], 0, 55)) . (mb_strlen($inc['descripcio']) > 55 ? '...' : ''); ?></td>
                    <td><?php echo $inc['prioritat'] ?? '-'; ?></td>
                    <td><?php echo htmlspecialchars($inc['nom_tecnic'] ?? 'Sense assignar'); ?></td>
                    <td><?php echo $inc['estat']; ?></td>
                    <td>
                        <a href="detall_incidencia.php?id=<?php echo $inc['id_incidencia']; ?>"
                           class="btn btn-warning btn-sm">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>

<?php if ($id_sel > 0):
    $stmt = $conn->prepare("
        SELECT i.*, d.nom AS nom_departament
        FROM INCIDENCIA i
        LEFT JOIN DEPARTAMENT d ON i.id_departament = d.id_departament
        WHERE i.id_incidencia = ?
    ");
    $stmt->execute([$id_sel]);
    $inc = $stmt->fetch();
?>
    <?php if ($inc): ?>
    <h3>Editant incidència #<?php echo $inc['id_incidencia']; ?></h3>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Departament:</strong> <?php echo htmlspecialchars($inc['nom_departament'] ?? '-'); ?></p>
            <p><strong>Data creació:</strong> <?php echo $inc['data_creacio']; ?></p>
            <p><strong>Descripció:</strong> <?php echo htmlspecialchars($inc['descripcio']); ?></p>
        </div>
    </div>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $inc['id_incidencia']; ?>">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Prioritat:</label>
                <select name="prioritat" class="form-select">
                    <option value="">-- Sense prioritat --</option>
                    <option value="alta"    <?php echo $inc['prioritat']==='alta'    ? 'selected':''; ?>>Alta</option>
                    <option value="mitjana" <?php echo $inc['prioritat']==='mitjana' ? 'selected':''; ?>>Mitjana</option>
                    <option value="baixa"   <?php echo $inc['prioritat']==='baixa'   ? 'selected':''; ?>>Baixa</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tècnic assignat:</label>
                <select name="id_tecnic" class="form-select">
                    <option value="">-- Sense tècnic --</option>
                    <?php foreach ($tecnics as $tec): ?>
                        <option value="<?php echo $tec['id_tecnic']; ?>"
                            <?php echo $inc['id_tecnic']==$tec['id_tecnic'] ? 'selected':''; ?>>
                            <?php echo htmlspecialchars($tec['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Estat:</label>
                <select name="estat" class="form-select">
                    <option value="oberta"    <?php echo $inc['estat']==='oberta'    ? 'selected':''; ?>>Oberta</option>
                    <option value="en_proces" <?php echo $inc['estat']==='en_proces' ? 'selected':''; ?>>En procés</option>
                    <option value="tancada"   <?php echo $inc['estat']==='tancada'   ? 'selected':''; ?>>Tancada</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-warning">Guardar canvis</button>
        <a href="detall_incidencia.php" class="btn btn-secondary">Cancel·lar</a>
    </form>
    <?php endif; ?>
<?php endif; ?>

<?php include 'peu.php'; ?>