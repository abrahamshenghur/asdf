
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

// $stmt = $pdo->query("SELECT id, year, make, model FROM vehicles_test");  // Using this line reverts grid order when page reloaded
$stmt = $pdo->query("SELECT id, year, make, model, vin FROM vehicles_test ORDER BY position");
$data = $stmt->fetchAll();

// Check if fetchData parameter is set to true
if (isset($_GET['fetchData']) && $_GET['fetchData'] == 'true') {
    $stmt = $pdo->query("SELECT id, year, make, model, vin FROM vehicles_test ORDER BY position");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    exit;  // Terminate the script here to prevent further HTML rendering
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Database</title>
    <style>
        th, td {
            text-align: left;
            padding : 8px;
        }
        #vehicle-grid {
            display: grid;
            /*grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));*/
            grid-template-columns: repeat(4, 150px);  /* Each item will have a width of 150px */
            gap: 15px;
            margin-top: 20px;
            margin-bottom: 100px;
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
            transition: background-color 0.3s;
        }

        .grid-item:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        
        .thumbnail-container {
            max-height: 120px;  /* Adjust based on 2 rows of thumbnails, including some margin */
            overflow-y: auto;  /* allow vertical scrolling */
            overflow-x: hidden;  /* prevent horizontal scrolling */
            display: flex;  /* use flexbox to organize the images */
            flex-wrap: wrap;  /* allow wrapping to the next line after 10 images */
        }
        
        .thumbnail {
            width: 50px;  /* width of a single thumbnail */
            margin-right: 5px;  /* spacing between images */
            margin-bottom: 5px;  /* spacing between rows */
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>
<body>

<form action="add.php" method="post">
    Year: <input type="text" name="year"><br>
    Make: <input type="text" name="make"><br>
    Model: <input type="text" name="model"><br>
    VIN: <input type="text" name="vin"><br>
    <input type="submit" value="Add Vehicle">
</form>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>VIN</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Upload Image</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 1;  // Initialize the counter
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $index . "</td>";  // Display the counter value
            echo "<td>" . htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['make'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['model'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['vin'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>";
            echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
            
            // Add the image upload form here
            echo "<td>";
            echo "<form action='upload_image.php' method='post' enctype='multipart/form-data'>";
            echo "<input type='file' name='vehicleImage' accept='image/*'>";
            echo "<input type='hidden' name='make' value='" . $row['make'] . "'>";
            echo "<input type='hidden' name='model' value='" . $row['model'] . "'>";
            echo "<input type='hidden' name='year' value='" . $row['year'] . "'>";
            echo "<input type='hidden' name='vin' value='" . $row['vin'] . "'>";
            echo "<input type='submit' value='Upload'>";
            echo "</form>";
            echo "</td>";
            
            // Image thumbnails display
            $lastFiveVin = substr($row['vin'], -5);
            $folderName = strtolower(str_replace(' ', '-', "{$row['make']}-{$row['model']}-{$row['year']}-{$lastFiveVin}"));
            $imgDirectory = "images/{$folderName}/";  // Assuming images are stored in an 'images' directory
            $imgPaths = glob($imgDirectory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            
            // Use natsort() for natural sorting of filenames
            natsort($imgPaths);
            
            // Re-index the sorted array
            $imgPaths = array_values($imgPaths);        
            
            echo "<td class='thumbnail-container'>";
            if (!empty($imgPaths)) {
                foreach ($imgPaths as $imgPath) {
                    echo "<img src='" . $imgPath . "' class='thumbnail' alt='Thumbnail'>";  // Display each image as a thumbnail
                }
            } else {
                echo "No Images";
            }
            echo "</td>";
        
            echo "</tr>";
            $index++;  // Increment the counter for the next row
        }
        ?>
    </tbody>
</table>

<div id="vehicle-grid">
    <?php
    $gridIndex = 1;  // Initialize the grid index counter
    foreach ($data as $row) {
        echo '<div class="grid-item" data-id="' . $row['id'] . '">';
        echo '<label># ' . $gridIndex . '</label><br>';
        echo '<label>Year: ' . $row['year'] . '</label><br>';
        echo '<label>Make: ' . $row['make'] . '</label><br>';
        echo '<label>Model: ' . $row['model'] . '</label>';
        echo '</div>';
        $gridIndex++;  // Increment the grid index for the next item
    }
    ?>
</div>

<script>
    var vehicleGrid = document.getElementById('vehicle-grid');
    var imageContainers = document.querySelectorAll('.thumbnail-container');
    
    new Sortable(vehicleGrid, {
        animation: 250,
        onUpdate: function(evt) {
            var itemOrder = [];
            vehicleGrid.querySelectorAll('.grid-item').forEach(function(item, index) {
                itemOrder.push({
                    id: item.getAttribute('data-id'),
                    position: index + 1  // Start position from 1
                });
            });
            updateDatabaseOrder(itemOrder);
        }
    });
    
    imageContainers.forEach(function(container) {
        new Sortable(container, {
            animation: 250,
            onUpdate: function(evt) {
                var imgOrder = [];
                container.querySelectorAll('img').forEach(function(img, index) {
                    imgOrder.push(img.src);  // Here, we're using the image source as an identifier
                });
                updateImageOrder(imgOrder);
            }
        });
    });
    

    function updateDatabaseOrder(order) {
        fetch('update_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(order)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fetch updated list from the server
                fetch('index.php?fetchData=true')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(updatedData => {
                        updateTableAndGrid(updatedData);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error.message);
                    });
            } else {
                console.error("Failed to update order:", data.error);
            }
        });
    }

    function updateTableAndGrid(data) {
        // Updating the table
        let tableBody = document.querySelector('table tbody');
        tableBody.innerHTML = '';
        
        let rowIndex = 1;  // Initialize the row index counter
        data.forEach(row => {
            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${rowIndex}</td>  <!-- Display the row index -->
                <td>${row.year}</td>
                <td>${row.make}</td>
                <td>${row.model}</td>
                <td>${row.vin}</td>
                <td><a href='edit.php?id=${row.id}'>Edit</a></td>
                <td><a href='delete.php?id=${row.id}'>Delete</a></td>
            `;
            tableBody.appendChild(tr);
            rowIndex++;  // Increment the row index for the next row
        });

        // Updating the grid
        let vehicleGrid = document.getElementById('vehicle-grid');
        vehicleGrid.innerHTML = '';
        
        let gridIndex = 1;  // Initialize the grid index counter
        data.forEach(row => {
            let div = document.createElement('div');
            div.className = 'grid-item';
            div.setAttribute('data-id', row.id);
            div.innerHTML = `
                <label># ${gridIndex}</label><br>  <!-- Display the grid index -->
                <label>Year: ${row.year}</label><br>
                <label>Make: ${row.make}</label><br>
                <label>Model: ${row.model}</label>
            `;
            vehicleGrid.appendChild(div);
            gridIndex++;  // Increment the grid index for the next grid item
        });
    }
    
    function updateImageOrder(order) {
        fetch('update_image_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(order)
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error("Failed to update image order:", data.error);
            }
        });
    }

    setInterval(fetchUpdatedData, 600000); // Currenlty, refresehing every 10 min. For real-time updates, set to 3000 (every 3 sec) if multiple users exists e.g. mobile user logs in and someone else is viewing from another location

    function fetchUpdatedData() {
        fetch('index.php?fetchData=true')
        .then(response => response.json())
        .then(updatedData => {
            updateTableAndGrid(updatedData);
        });
    }

</script>

</body>
</html>
