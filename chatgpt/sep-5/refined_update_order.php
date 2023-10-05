<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("Received payload: " . file_get_contents('php:

include '../../db_config.php';
$host = HOST;
$user = USERNAME;
$pass = PASSWORD;
$db   = DATABASE;
$charset = CHARSET;








$data = json_decode(file_get_contents('php:
if ($data) {
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $success = true;
    foreach ($data as $item) {
        $id = $item['id'];
        $position = $item['position'];

if (!is_numeric($id) || !is_numeric($position)) {
    die("Invalid ID or position.");
}
$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
$position = filter_var($position, FILTER_SANITIZE_NUMBER_INT);

        
        
$stmt = $conn->prepare("UPDATE vehicles_test SET position=? WHERE id=?");
if (!$stmt->bind_param("ii", $position, $id) || !$stmt->execute()) {
    $success = false;
}

            $success = false;
        }
    }

    echo json_encode(['success' => $success, 'error' => $conn->error]);
    $conn->close();
}

?>
