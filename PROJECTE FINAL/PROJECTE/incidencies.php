<?php
require_once 'conexio.php'; 

$sql = "SELECT * FROM INCIDENCIA";

$query = mysqli_query($conn, $sql);

$resultat = $query;
?>




// Dades de prova per si la BBDD encara no et respon
/*$resultat = [
    ['id_incidencia'=>1, 'departament'=>'Informàtica', 'descripcio'=>'Monitor trencat', 'estat'=>'Oberta', 'prioritat'=>'Alta', 'tecnic'=>'Joan'],
    ['id_incidencia'=>2, 'departament'=>'Secretaria', 'descripcio'=>'No imprimeix', 'estat'=>'Tancada', 'prioritat'=>'Baixa', 'tecnic'=>'Marta'],
    ['id_incidencia'=>3, 'departament'=>'Pasdasd', 'descripcio'=>'BLABLA', 'estat'=>'Tancada', 'prioritat'=>'Baixa', 'tecnic'=>'Marta'],

    ];
    */
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llistat d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>ssword 
<body class="bg-light p-4">

<div class="container bg-white p-4 shadow rounded">
    <h1 class="mb-4 text-center">Llistat d'incidències</h1>
    
    <table class="table table-hover border">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Dept.</th>
                <th>Descripció</th>
                <th>Estat</th>
                <th>Prioritat</th>
                <th>Tècnic</th>ç
                <th>PATATA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($resultat as $fila) { 
                
                    $classe_fila = ($fila['prioritat'] == 'Alta') ? 'table-danger' : '';
                ?>
                <tr class="<?= $classe_fila ?>">
                    <td><strong>#<?= $fila['id_incidencia'] ?></strong></td>
                    <td><?= $fila['departament'] ?></td>
                    <td><?= $fila['descripcio'] ?></td>
                    <td><span class="badge bg-info text-dark"><?= $fila['estat'] ?></span></td>
                    <td><?= $fila['prioritat'] ?></td>
                    <td><?= $fila['tecnic'] ?></td>
                    <td>POMA</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-secondary">Tornar a l'Inici</a>
    </div>
</div>

</body>
</html>