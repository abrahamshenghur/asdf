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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $year = $_POST['year'];
    $make = $_POST['make'];
    $model = $_POST['model'];
    $vin = $_POST['vin'];
    
    // Validation
    if (!is_numeric($id)) {
        die("Invalid ID.");
    }
    
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
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    $make = filter_var($make, FILTER_SANITIZE_SPECIAL_CHARS);
    $model = filter_var($model, FILTER_SANITIZE_SPECIAL_CHARS);
    $vin = filter_var($vin, FILTER_SANITIZE_SPECIAL_CHARS);
    
    $stmt = $pdo->prepare("UPDATE vehicles_test SET year = ?, make = ?, model = ?, vin = ? WHERE id = ?");
    $stmt->execute([$year, $make, $model, $vin, $id]);

    // Update JSON file
    updateJson($pdo);
    header('Location: index.php');
} elseif (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM vehicles_test WHERE id = ?");

    if (!is_numeric($_GET['id'])) {
        die("Invalid ID.");
    }
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt->execute([$id]);

    $vehicle = $stmt->fetch();
} else {
    header('Location: index.php');
}

function updateJson($pdo) {
    $stmt = $pdo->query("SELECT year, make, model FROM vehicles_test");
    $data = $stmt->fetchAll();

    file_put_contents('test.json', json_encode($data, JSON_PRETTY_PRINT));
}
?>

<form action="edit.php" method="post">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($vehicle['id'], ENT_QUOTES, 'UTF-8'); ?>">
    Year: <input type="text" name="year" value="<?php echo htmlspecialchars($vehicle['year'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    Make: <input type="text" name="make" value="<?php echo htmlspecialchars($vehicle['make'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    Model: <input type="text" name="model" value="<?php echo htmlspecialchars($vehicle['model'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    VIN: <input type="text" name="vin" value="<?php echo htmlspecialchars($vehicle['vin'], ENT_QUOTES, 'UTF-8'); ?>"><br>
    <input type="submit" value="Update Vehicle">
</form>
