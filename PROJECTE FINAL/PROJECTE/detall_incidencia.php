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

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Incidències</title>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    
    <div class="mb-4">
        <h1 class="fw-bold">Modificar Incidències</h1>
        <p class="text-muted">Incidències no resoltes. Clica "Editar" per modificar-ne els detalls.</p>
    </div>

    <?php if ($ok): ?>
        <div class="alert alert-success shadow-sm">Incidència actualitzada correctament!</div>
    <?php endif; ?>

    <?php if (empty($incidencies)): ?>
        <div class="alert alert-info">No hi ha incidències obertes en aquest moment.</div>
    <?php else: ?>
        <div class="card shadow-sm mb-5">
            <div class="card-body p-0"> <div class="table-responsive">
                    <table class="table table-hover mb-0">
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
                                    <td><?php echo date('d/m/Y', strtotime($inc['data_creacio'])); ?></td>
                                    <td><?php echo htmlspecialchars(mb_substr($inc['descripcio'], 0, 55)) . (mb_strlen($inc['descripcio']) > 55 ? '...' : ''); ?></td>
                                    <td class="text-uppercase small fw-bold"><?php echo $inc['prioritat'] ?? '-'; ?></td>
                                    <td><?php echo htmlspecialchars($inc['nom_tecnic'] ?? 'Sense assignar'); ?></td>
                                    <td><span class="badge bg-dark"><?php echo $inc['estat']; ?></span></td>
                                    <td>
                                        <a href="detall_incidencia.php?id=<?php echo $inc['id_incidencia']; ?>"
                                           class="btn btn-warning btn-sm fw-bold">Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
        <div class="card border-warning shadow-sm mt-4">
            <div class="card-header bg-warning fw-bold text-dark">
                Editant incidència #<?php echo $inc['id_incidencia']; ?>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-4"><strong>Departament:</strong> <p><?php echo htmlspecialchars($inc['nom_departament'] ?? '-'); ?></p></div>
                    <div class="col-md-4"><strong>Data creació:</strong> <p><?php echo date('d/m/Y H:i', strtotime($inc['data_creacio'])); ?></p></div>
                    <div class="col-md-4"><strong>Descripció:</strong> <p><?php echo htmlspecialchars($inc['descripcio']); ?></p></div>
                </div>

                <hr>

                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $inc['id_incidencia']; ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Prioritat:</label>
                            <select name="prioritat" class="form-select">
                                <option value="">-- Sense prioritat --</option>
                                <option value="alta"    <?php echo $inc['prioritat']==='alta'    ? 'selected':''; ?>>Alta</option>
                                <option value="mitjana" <?php echo $inc['prioritat']==='mitjana' ? 'selected':''; ?>>Mitjana</option>
                                <option value="baixa"   <?php echo $inc['prioritat']==='baixa'   ? 'selected':''; ?>>Baixa</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Tècnic assignat:</label>
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
                            <label class="form-label fw-bold">Estat:</label>
                            <select name="estat" class="form-select">
                                <option value="oberta"    <?php echo $inc['estat']==='oberta'    ? 'selected':''; ?>>Oberta</option>
                                <option value="en_proces" <?php echo $inc['estat']==='en_proces' ? 'selected':''; ?>>En procés</option>
                                <option value="tancada"   <?php echo $inc['estat']==='tancada'   ? 'selected':''; ?>>Tancada</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning fw-bold px-4">Guardar canvis</button>
                        <a href="detall_incidencia.php" class="btn btn-outline-secondary px-4">Cancel·lar</a>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

</div> <?php include 'peu.php'; ?>
</body>
</html>