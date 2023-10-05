<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("Received payload: " . file_get_contents('php://input'));


include '../../db_config.php';
$host = HOST;
$user = USERNAME;
$pass = PASSWORD;
$db   = DATABASE;
$charset = CHARSET;

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];
// $pdo = new PDO($dsn, $user, $pass, $options);

// $data = json_decode(file_get_contents('php://input'), true);

// if (isset($data['order'])) {
//     echo "Received order: " . implode(", ", $data['order']);

//     foreach ($data['order'] as $index => $id) {
//         $stmt = $pdo->prepare("UPDATE vehicles_test SET position = ? WHERE id = ?");
//         $stmt->execute([$index, $id]);
//     }
//     echo "Update complete.";

//     // Update JSON file
//     $stmt = $pdo->query("SELECT year, make, model FROM vehicles_test ORDER BY position ASC");
//     $vehicles = $stmt->fetchAll();

//     file_put_contents('test.json', json_encode($vehicles));
// } else {
//     echo "No order received.";
// }


$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $success = true;
    foreach ($data as $item) {
        $id = $item['id'];
        $position = $item['position'];
        
        $sql = "UPDATE vehicles_test SET position=$position WHERE id=$id";
        if (!$conn->query($sql)) {
            $success = false;
        }
    }

    echo json_encode(['success' => $success, 'error' => $conn->error]);
    $conn->close();
}

?>
