
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
        /* Light mode (default) */
        :root {
            --background-color: white;
            --text-color: black;
            --link-color: blue;
            --border-color: #ccc;
            --hover-background: #f5f5f5;
        }
        
        /* Dark mode */
        [data-theme='dark'] {
            --background-color: #474852eb;
            --text-color: #e8e8e8;
            --link-color: #c5aee3;
            --border-color: #333;
            --hover-background: #1f1f1f;
        }
        
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        a {
            color: var(--link-color);
        }
        
        /* Style for the toggle button */
        .dark-mode-toggle {
            position: absolute;   /* or use 'absolute' if you have a relative container */
            top: 10px;         /* 10px from the top */
            right: 10px;       /* 10px from the right */
            z-index: 1000;     /* Ensures the button is above other elements */
            padding: 8px 12px; /* Optional padding for aesthetics */
        }

        .vehicle-form {
            display: flex;             /* Make the form a flex container */
            justify-content: space-between; /* Space out the form fields equally */
            align-items: center;       /* Vertically center align the text and form fields */
            width: 100%;               /* Make the form take the full width of its container */
            margin-top: 80px;
            margin-bottom: 20px;       /* Add some space below the form */
        }
        
        .vehicle-form .input-group {
            display: flex;             /* Make the input group a flex container */
            align-items: center;       /* Vertically center align the text and input field */
        }
        
        .vehicle-form .input-group label {
            margin-right: 10px;        /* Add some space between the label and input field */
        }
        
        .vehicle-form > input[type="submit"] {
            margin-left: 20px;         /* Add some space to the left of the submit button */
        }
        
        .vehicle-form > input, .vehicle-form .input-group > input {
            padding: 5px 10px;         /* Add padding to the input fields */
        }
        
        table {
            width: 100%;
        }


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
            justify-content: center; /* Center the grid items */
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
        
        #vehicle-grid .grid-item {
            border-color: var(--border-color);
        }
        
        .grid-item:hover {
            background-color: var(--hover-background);
        }
    </style>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>

<body>
<button id="toggleDarkMode" class="dark-mode-toggle">Toggle Dark Mode</button>

<form action="add.php" method="post" class="vehicle-form">
    <div class="input-group">
        <label for="year">Year:</label>
        <input type="text" name="year" id="year">
    </div>
    <div class="input-group">
        <label for="make">Make:</label>
        <input type="text" name="make" id="make">
    </div>
    <div class="input-group">
        <label for="model">Model:</label>
        <input type="text" name="model" id="model">
    </div>
    <div class="input-group">
        <label for="vin">VIN:</label>
        <input type="text" name="vin" id="vin">
    </div>
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
            echo "<input type='file' name='vehicleImage[]' accept='image/*' multiple>";
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
            // file_put_contents('error_log.log', "Retrieved image paths: " . json_encode($imgPaths) . "\n", FILE_APPEND);

            // Fetch image order from the database
            $orderStmt = $pdo->prepare("SELECT image_name FROM image_order WHERE vehicle_id = ? ORDER BY position ASC");
            $orderStmt->execute([$row['id']]);
            $imageOrder = $orderStmt->fetchAll(PDO::FETCH_COLUMN, 0);
            // file_put_contents('error_log.log', "Retrieved image order: " . json_encode($imageOrder) . "\n", FILE_APPEND);

            // Logging before sorting
            file_put_contents('log_before_sort.txt', "Image Paths:\n" . print_r($imgPaths, true) . "\n\nImage Order:\n" . print_r($imageOrder, true));
            
            // $baseURL = "https://westcoastmts.com/test/";
            
            // $imageOrder = array_map(function($url) use ($baseURL) {
            //     return str_replace($baseURL, '', $url);
            // }, $imageOrder);
            
            usort($imgPaths, function($a, $b) use ($imageOrder) {
                $aName = basename($a);
                $bName = basename($b);
                
                $aPosition = array_search($aName, $imageOrder);
                $bPosition = array_search($bName, $imageOrder);
            
                // If both images are not in the database, maintain their current order
                if ($aPosition === false && $bPosition === false) return 0;
            
                // If only one of them is not in the database, push it to the end
                if ($aPosition === false) return 1;
                if ($bPosition === false) return -1;
            
                // Compare based on their positions in the database
                return $aPosition - $bPosition;
            });
            
            // Logging after sorting
            file_put_contents('log_after_sort.txt', "Image Paths:\n" . print_r($imgPaths, true) . "\n\nImage Order:\n" . print_r($imageOrder, true));


            echo "<td class='thumbnail-container' data-vehicle-id='" . $row['id'] . "'>";
            if (!empty($imageOrder)) {
                foreach ($imageOrder as $imageName) {
                    file_put_contents('error_log.log', "imageNam: " . $imageName . "\n", FILE_APPEND);
                    echo "<img src='" . $imageName . "' class='thumbnail' alt='Thumbnail'>";  // Display each image as a thumbnail
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
    
    
    var imageContainers = document.querySelectorAll('.thumbnail-container');
    imageContainers.forEach(function(container) {
        new Sortable(container, {
            animation: 250,
            onUpdate: function(evt) {
                var imgOrder = [];
                container.querySelectorAll('img').forEach(function(img, index) {
                    imgOrder.push(img.src);  // Here, we're using the image source as an identifier
                });
                
                // Get the vehicleId from the data-vehicle-id attribute of the current container
                var vehicleId = container.getAttribute('data-vehicle-id');

                updateImageOrder(vehicleId, imgOrder);
            }
        });
    });
    
    
    function updateImageOrder(vehicleId, order) {
        console.log('updateImageOrder called')
        fetch('update_image_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                vehicleId: vehicleId,
                order: order
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error("Failed to update image order:", data.error);
            }
        });
    }

    function updateDatabaseOrder(order) {
        console.log("Sending order to server:", order);  // <-- Add this line here
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

    setInterval(fetchUpdatedData, 600000); // Currenlty, refresehing every 10 min. For real-time updates, set to 3000 (every 3 sec) if multiple users exists e.g. mobile user logs in and someone else is viewing from another location

    function fetchUpdatedData() {
        fetch('index.php?fetchData=true')
        .then(response => response.json())
        .then(updatedData => {
            updateTableAndGrid(updatedData);
        });
    }

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
    
    if (currentTheme) {
        document.documentElement.setAttribute('data-theme', currentTheme);
    }
    
    // Toggle dark mode on button click
    document.getElementById('toggleDarkMode').addEventListener('click', function() {
        let currentTheme = document.documentElement.getAttribute("data-theme");
        if (currentTheme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light'); // Save preference in local storage
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark'); // Save preference in local storage
        }            
    });
});
</script>

</body>
</html>
