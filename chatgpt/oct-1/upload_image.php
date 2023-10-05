<?php
include '../../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch data from form
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $vin = $_POST['vin'];
    $vehicleId = $_POST['vehicleId'];

    // Define the base directory
    $baseDir = "images";

    // Create folder name and replace spaces with dashes
    $lastFiveVin = substr($vin, -5);
    $folderName = "{$make}-{$model}-{$year}-{$lastFiveVin}";
    $folderName = strtolower(str_replace(' ', '-', $folderName));

    // Create the full path including the base directory
    $fullPath = $baseDir . "/" . $folderName;

    // Check if the base directory exists; if not, create it
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0755);
    }

    // Create vehicle-specific folder if not exists
    if (!file_exists($fullPath)) {
        mkdir($fullPath, 0777, true);
    }
    
    echo "Number of files uploaded: " . count($_FILES['vehicleImage']['name']) . "<br>";
    print_r($_FILES['vehicleImage']['error']);


    // Loop through each uploaded file
    for ($i = 0; $i < count($_FILES['vehicleImage']['name']); $i++) {
        $targetFile = $fullPath . '/' . basename($_FILES["vehicleImage"]["name"][$i]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["vehicleImage"]["tmp_name"][$i]);
        if($check === false) {
            die("File " . $_FILES["vehicleImage"]["name"][$i] . " is not an image.<br>");
        }
        
        // Allowed file types
        $allowedTypes = ["jpg", "jpeg", "png", "gif", "webp"];
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Sorry, only JPG, JPEG, PNG, GIF & WEBP files are allowed for file " . $_FILES["vehicleImage"]["name"][$i] . ".<br>");
        }

        // Move uploaded file to the target folder
        if (move_uploaded_file($_FILES["vehicleImage"]["tmp_name"][$i], $targetFile)) {
            echo "The file ". basename($_FILES["vehicleImage"]["name"][$i]). " has been uploaded.<br>";
            
            // Insert into the image_order table
            $insertStmt = $pdo->prepare("INSERT INTO image_order (vehicle_id, image_name, position) VALUES (?, ?, ?)");
            
            // Assuming the vehicle ID is known and is stored in a variable called $vehicleId
            // Use $i for the position (or another method to determine the order)
            $insertStmt->execute([$vehicleId, $targetFile, $i]);
        } else {
            echo "Sorry, there was an error uploading file: " . basename($_FILES["vehicleImage"]["name"][$i]) . "<br>";
        }
    }
}
?>
