
<?php
$host = 'localhost';
$db   = 'your_database';
$user = 'your_username';
$pass = 'your_password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

// Adding a vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];

    $stmt = $pdo->prepare("INSERT INTO vehicles (year, make, model) VALUES (?, ?, ?)");
    $stmt->execute([$year, $make, $model]);

    // Update JSON file
    updateJson($pdo);
}

function updateJson($pdo) {
    $stmt = $pdo->query("SELECT year, make, model FROM vehicles");
    $data = $stmt->fetchAll();

    file_put_contents('test.json', json_encode($data));
}

header('Location: index.php');
?>
