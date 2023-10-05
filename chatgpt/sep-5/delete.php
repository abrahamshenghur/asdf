<?php
include '../../db_config.php';
$host = HOST;
$user = USERNAME;
$pass = PASSWORD;
$db   = DATABASE;
$charset = CHARSET;

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM vehicles_test WHERE id = ?");
    $stmt->execute([$_GET['id']]);

    // Update JSON file
    updateJson($pdo);
}

function updateJson($pdo) {
    $stmt = $pdo->query("SELECT year, make, model FROM vehicles_test");
    $data = $stmt->fetchAll();

    file_put_contents('test.json', json_encode($data, JSON_PRETTY_PRINT));
}

header('Location: index.php');
?>
