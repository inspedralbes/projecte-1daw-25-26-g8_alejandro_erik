<?php
include 'conexio.php';
include 'includes/cap.php';

$stmt = $conn->query("
    SELECT i.*, d.nom AS nom_departament, t.nom AS nom_tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTAMENT d ON i.id_departament = d.id_departament
    LEFT JOIN TECNIC t      ON i.id_tecnic      = t.id_tecnic
    ORDER BY
        i.estat ASC,
        FIELD(i.prioritat, 'alta', 'mitjana', 'baixa'),
        i.data_creacio ASC
");
$incidencies = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    

<h1 class="page-title">Llistat d'Incidències</h1>

<div class="mb-3">
    <span class="badge bg-danger me-1">Alta</span>
    <span class="badge bg-warning text-dark me-1">Mitjana</span>
    <span class="badge bg-success me-1">Baixa</span>
    <span class="badge bg-secondary">Tancada</span>
    &nbsp; Colors per prioritat
</div>

<div class="table-responsive">
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Departament</th>
            <th>Data</th>
            <th>Descripció</th>
            <th>Prioritat</th>
            <th>Tècnic</th>
            <th>Estat</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($incidencies as $inc):
            if ($inc['estat'] === 'tancada') {
                $classe = 'table-secondary';
            } elseif ($inc['prioritat'] === 'alta') {
                $classe = 'table-danger';
            } elseif ($inc['prioritat'] === 'mitjana') {
                $classe = 'table-warning';
            } elseif ($inc['prioritat'] === 'baixa') {
                $classe = 'table-success';
            } else {
                $classe = '';
            }
        ?>
            <tr class="<?php echo $classe; ?>">
                <td><strong>#<?php echo $inc['id_incidencia']; ?></strong></td>
                <td><?php echo htmlspecialchars($inc['nom_departament'] ?? '-'); ?></td>
                <td><?php echo $inc['data_creacio']; ?></td>
                <td><?php echo htmlspecialchars(mb_substr($inc['descripcio'], 0, 60)) . (mb_strlen($inc['descripcio']) > 60 ? '...' : ''); ?></td>
                <td><?php echo $inc['prioritat'] ?? '-'; ?></td>
                <td><?php echo htmlspecialchars($inc['nom_tecnic'] ?? 'Sense assignar'); ?></td>
                <td>
                    <?php if ($inc['estat'] === 'tancada'): ?>
                        <span class="badge bg-secondary">Tancada</span>
                    <?php elseif ($inc['estat'] === 'en_proces'): ?>
                        <span class="badge bg-primary">En procés</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Oberta</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="afegir_actuacio.php?id=<?php echo $inc['id_incidencia']; ?>" class="btn btn-sm btn-primary">Actuació</a>
                    <?php if ($inc['estat'] !== 'tancada'): ?>
                        <a href="detall_incidencia.php?id=<?php echo $inc['id_incidencia']; ?>" class="btn btn-sm btn-warning">Modificar</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<p><strong>Total incidències:</strong> <?php echo count($incidencies); ?></p>
<a href="crear_incidencies.php" class="btn btn-primary">Nova Incidència</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<?php include 'includes/peu.php'; ?>
</body>
</html>