
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

$stmt = $pdo->query("SELECT MAX(position) as maxPosition FROM vehicles_test");
$maxPosition = $stmt->fetchColumn();
$newPosition = $maxPosition + 1;


// Adding a vehicle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $vin = $_POST['vin'];
    
    // Validation    
    $currentYear = date("Y");
    
    if (!is_numeric($year) || $year < 1900 || $year > $currentYear) {
        die("Invalid year.");
    }
    if (!is_string($make) || strlen($make) > 50) {
        die("Invalid make.");
    }
    if (!is_string($model) || strlen($model) > 50) {
        die("Invalid model.");
    }
    if (!is_string($vin) || strlen($vin) > 17) {
        die("Invalid VIN.");
    }

    // Sanitization
    $make = filter_var($make, FILTER_SANITIZE_SPECIAL_CHARS);
    $model = filter_var($model, FILTER_SANITIZE_SPECIAL_CHARS);
    $vin = filter_var($vin, FILTER_SANITIZE_SPECIAL_CHARS);

    $stmt = $pdo->prepare("INSERT INTO vehicles_test (year, make, model, vin, position) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$year, $make, $model, $vin, $newPosition]);

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
