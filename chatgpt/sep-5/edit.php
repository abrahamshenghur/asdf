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

    $stmt = $pdo->prepare("UPDATE vehicles_test SET year = ?, make = ?, model = ? WHERE id = ?");
    $stmt->execute([$year, $make, $model, $id]);

    // Update JSON file
    updateJson($pdo);
    header('Location: index.php');
} elseif (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM vehicles_test WHERE id = ?");
    $stmt->execute([$_GET['id']]);
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
    <input type="hidden" name="id" value="<?php echo $vehicle['id']; ?>">
    Year: <input type="text" name="year" value="<?php echo $vehicle['year']; ?>"><br>
    Make: <input type="text" name="make" value="<?php echo $vehicle['make']; ?>"><br>
    Model: <input type="text" name="model" value="<?php echo $vehicle['model']; ?>"><br>
    <input type="submit" value="Update Vehicle">
</form>
