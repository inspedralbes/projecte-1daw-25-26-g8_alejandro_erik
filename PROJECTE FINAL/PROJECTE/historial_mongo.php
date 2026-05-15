<?php
include 'cap.php';
require_once 'mongo.php';

$logs = getHistorial(50);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Historial MongoDB</title>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="fw-bold mb-4">📋 Historial d'accions</h1>

    <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Data</th>
                    <th>Acció</th>
                    <th>Usuari</th>
                    <th>Dades</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hi ha registres encara.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo $log['timestamp']->toDateTime()->format('d/m/Y H:i:s'); ?></td>
                            <td>
                                <?php
                                $badge = match($log['accio']) {
                                    'crear'       => 'success',
                                    'actualitzar' => 'warning',
                                    'eliminar'    => 'danger',
                                    default       => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?php echo $badge; ?>">
                                    <?php echo strtoupper($log['accio']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($log['usuari']); ?></td>
                            <td>
                                <small>
                                <?php foreach ($log['dades'] as $clau => $valor): ?>
                                    <strong><?php echo $clau; ?>:</strong> <?php echo htmlspecialchars($valor); ?><br>
                                <?php endforeach; ?>
                                </small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'peu.php'; ?>
</body>
</html>