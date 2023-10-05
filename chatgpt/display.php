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

// Function to save data to test.json
function save_to_json($data) {
    $json_data = json_decode(file_get_contents('test.json'), true);
    $json_data[] = $data;
    file_put_contents('test.json', json_encode($json_data, JSON_PRETTY_PRINT));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("INSERT INTO vehicles (year, make, model, price, mileage, vin, color, type, drive, engine, fuel, description, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiissssssss", $_POST['year'], $_POST['make'], $_POST['model'], $_POST['price'], $_POST['mileage'], $_POST['vin'], $_POST['color'], $_POST['type'], $_POST['drive'], $_POST['engine'], $_POST['fuel'], $_POST['description'], $_POST['image_path']);
    if ($stmt->execute()) {
        // Save to test.json
        save_to_json($_POST);
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Year</th>
                <th>Make</th>
                <th>Model</th>
                <th>Price</th>
                <th>Mileage</th>
                <th>VIN</th>
                <th>Color</th>
                <th>BodyType</th>
                <th>DriveType</th>
                <th>Engine</th>
                <th>Fuel</th>
                <th>Description</th>
                <th>Image Path</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["year"] . "</td>
                <td>" . $row["make"] . "</td>
                <td>" . $row["model"] . "</td>
                <td>" . $row["price"] . "</td>
                <td>" . $row["mileage"] . "</td>
                <td>" . $row["vin"] . "</td>
                <td>" . $row["color"] . "</td>
                <td>" . $row["type"] . "</td>
                <td>" . $row["drive"] . "</td>
                <td>" . $row["engine"] . "</td>
                <td>" . $row["fuel"] . "</td>
                <td>" . $row["description"] . "</td>
                <td>" . $row["image_path"] . "</td>
                <td><a href='edit.php?id=" . $row["id"] . "'>Edit</a></td>
                <td><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No vehicles found!";
}
$conn->close();
?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    Year: <input type="number" name="year" required><br>
    Make: <input type="text" name="make" required><br>
    Model: <input type="text" name="model" required><br>
    Price: <input type="number" name="price" required><br>
    Mileage: <input type="number" name="mileage" required><br>
    VIN: <input type="text" name="vin" required><br>
    Color: <input type="text" name="color" required><br>
    BodyType: <input type="text" name="type" required><br>
    DriveType: <input type="text" name="drive" required><br>
    Engine: <input type="text" name="engine" required><br>
    Fuel: <input type="text" name="fuel" required><br>
    Description: <textarea name="description" required></textarea><br>
    Image Path: <input type="text" name="image_path"><br>
    <input type="submit" value="Add New Vehicle">
</form>
