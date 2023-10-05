
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

$data = json_decode(file_get_contents('php://input'), true);
$vehicleId = $data['vehicleId']; // Extracting vehicleId from the data
$imagesOrder = $data['order'];

$response = ['success' => true];

try {
    foreach ($imagesOrder as $position => $imageName) {
        // Store the image name and its position in the database
        $stmt = $pdo->prepare("INSERT INTO image_order (vehicle_id, image_name, position) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE position = ?");
        $stmt->execute([$vehicleId, $imageName, $position, $position]);
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

echo json_encode($response);
?>
