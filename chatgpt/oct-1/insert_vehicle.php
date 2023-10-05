<?php
include '../../db_config.php';
$host = HOST;
$user = USERNAME;
$pass = PASSWORD;
$db   = DATABASE;
$charset = CHARSET;

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$make = $_POST['make'];
$model = $_POST['model'];
$year = $_POST['year'];
$price = $_POST['price'];
$mileage = $_POST['mileage'];
$last_5_vin = $_POST['last_5_vin'];
$engine_type = $_POST['engine_type'];
$engine_size = $_POST['engine_size'];
$transmission = $_POST['transmission'];
$fuel_spec = $_POST['fuel_spec'];
$exterior_color = $_POST['exterior_color'];
$interior_color = $_POST['interior_color'];
$body_style = $_POST['body_style'];
$body_doors = $_POST['body_doors'];
$seats = $_POST['seats'];
$image_path = $_POST['image_path'];
$image_count = $_POST['image_count'];
$vehicle_info_color = $_POST['exterior_color'];
$vehicle_info_transmission = $_POST['transmission'];
$vehicle_info_mileage = $_POST['mileage'];
$maintenance_service = $_POST['maintenance_service'];

// Prepare SQL query
$sql = "INSERT INTO vehicles (
    make, model, year, price, mileage, last_5_vin, engine_type, engine_size, transmission,
    fuel_spec, exterior_color, interior_color, body_style, body_doors, seats, image_path,
    image_count, vehicle_info_color, vehicle_info_transmission, vehicle_info_mileage, maintenance_service
) VALUES (
    '$make', '$model', '$year', '$price', '$mileage', '$last_5_vin', '$engine_type', '$engine_size', '$transmission',
    '$fuel_spec', '$exterior_color', '$interior_color', '$body_style', '$body_doors', '$seats', '$image_path',
    '$image_count', '$vehicle_info_color', '$vehicle_info_transmission', '$vehicle_info_mileage', '$maintenance_service'
)";

// Execute SQL query
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>