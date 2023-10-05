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

// Function to update test.json
function update_json($id, $data) {
    $json_data = json_decode(file_get_contents('test.json'), true);
    foreach ($json_data as $key => $value) {
        if (isset($value['id']) && $value['id'] == $id) {
            $json_data[$key] = $data;
            break;
        }
    }
    file_put_contents('test.json', json_encode($json_data, JSON_PRETTY_PRINT));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("UPDATE vehicles SET year=?, make=?, model=?, price=?, mileage=?, vin=?, color=?, type=?, drive=?, engine=?, fuel=?, description=?, image_path=? WHERE id=?");
    $stmt->bind_param("issiissssssssi", $_POST['year'], $_POST['make'], $_POST['model'], $_POST['price'], $_POST['mileage'], $_POST['vin'], $_POST['color'], $_POST['type'], $_POST['drive'], $_POST['engine'], $_POST['fuel'], $_POST['description'], $_POST['image_path'], $_POST['id']);
    if ($stmt->execute()) {
        // Update test.json
        $updated_data = array(
            "year" => $_POST['year'],
            "make" => $_POST['make'],
            "model" => $_POST['model'],
            "price" => $_POST['price'],
            "mileage" => $_POST['mileage'],
            "vin" => $_POST['vin'],
            "color" => $_POST['color'],
            "type" => $_POST['type'],
            "drive" => $_POST['drive'],
            "engine" => $_POST['engine'],
            "fuel" => $_POST['fuel'],
            "description" => $_POST['description'],
            "image_path" => $_POST['image_path'],
            "id" => $_POST['id']
        );
        update_json($_POST['id'], $updated_data);
        header("Location: display.php"); exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    $sql = "SELECT * FROM vehicles WHERE id=" . $_GET['id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display form with pre-filled data for editing
        echo '
        <form action="edit.php" method="post">
            Year: <input type="text" name="year" value="' . $row["year"] . '"><br>
            Make: <input type="text" name="make" value="' . $row["make"] . '"><br>
            Model: <input type="text" name="model" value="' . $row["model"] . '"><br>
            Price: <input type="text" name="price" value="' . $row["price"] . '"><br>
            Mileage: <input type="text" name="mileage" value="' . $row["mileage"] . '"><br>
            VIN: <input type="text" name="vin" value="' . $row["vin"] . '"><br>
            Color: <input type="text" name="color" value="' . $row["color"] . '"><br>
            BodyType: <input type="text" name="type" value="' . $row["type"] . '"><br>
            DriveType: <input type="text" name="drive" value="' . $row["drive"] . '"><br>
            Engine: <input type="text" name="engine" value="' . $row["engine"] . '"><br>
            Fuel: <input type="text" name="fuel" value="' . $row["fuel"] . '"><br>
            Description: <textarea name="description">' . $row["description"] . '</textarea><br>
            Image Path: <input type="text" name="image_path" value="' . $row["image_path"] . '"><br>
            <input type="hidden" name="id" value="' . $row["id"] . '">
            <input type="submit" value="Update Vehicle">
        </form>
        ';
    } else {
        echo "Vehicle not found!";
    }
}

$conn->close();
?>

