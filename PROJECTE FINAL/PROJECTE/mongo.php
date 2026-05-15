<?php
require 'vendor/autoload.php';

try {
    $mongoClient = new MongoDB\Client(
        "mongodb://root:example@mongo:27017/?authSource=admin"

        // A producció
    //$mongoClient = new MongoDB\Client("mongodb+srv://a22alemanrey_db_user:<db_password>@cluster0.fikmnwv.mongodb.net/?appName=Cluster0"
    );

    $mongoDB    = $mongoClient->selectDatabase('logs');
    $collection = $mongoDB->selectCollection('logs');

} catch (Exception $e) {
    die("Error connexió MongoDB: " . $e->getMessage());
}


$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$hora = date("H:i:s");

$collection->insertOne([
    'name' => 'Anna',
    'age' => 28,
    'ip_origin' => $ip,
    'date' => $hora
]);
echo "Dades inserides a demo .\n";




function logAccio(string $accio, array $dades): void {
    global $collection;

    $collection->insertOne([
        'accio'     => $accio,
        'dades'     => $dades,
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
        'usuari'    => $_SESSION['usuari'] ?? 'anònim',
    ]);
}

function getHistorial(int $limit = 50): array {
    global $collection;

    $cursor = $collection->find(
        [],
        ['sort' => ['timestamp' => -1], 'limit' => $limit]
    );

    return iterator_to_array($cursor);
}

