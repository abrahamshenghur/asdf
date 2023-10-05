<?php
$server = "server";
$username = "username";
$password = "password";
$dbname = "dbname";

// Create connection
$conn = new mysqli($server, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to remove entry from test.json
function remove_from_json($id) {
    $json_data = json_decode(file_get_contents('test.json'), true);
    foreach ($json_data as $key => $value) {
        if ($value['id'] == $id) {
            unset($json_data[$key]);
            break;
        }
    }
    file_put_contents('test.json', json_encode(array_values($json_data), JSON_PRETTY_PRINT));
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $sql = "DELETE FROM vehicles WHERE id=" . $_GET['id'];
    if ($conn->query($sql) === TRUE) {
        // Remove from test.json
        remove_from_json($_GET['id']);
        header("Location: display.php"); exit;
    } else {
        echo "Error deleting vehicle: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}

$conn->close();
?>

