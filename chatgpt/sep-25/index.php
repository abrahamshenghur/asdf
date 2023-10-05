<?php
include '../../db_connect.php';

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }
        th, td {
            /*border: 1px solid black;*/
            /*text-align: center;*/
            padding: 8px;
        }
        .table-header-cell {
            background-color: #0c68b5; /* Light green background */
        }
        .table-data-cell {
            background-color: #f7f3e8; /* Light grey background */
        }
        /*.description-cell {*/
        /*    background-color: #fce4ec; */
        /*}*/
        .description-container {
            margin-bottom: 10px; /* Spacing underneath the description row */
        }
        
        .spacer-row {
            height: 10px; /* Adjust as needed */
            background-color: white;
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

<body class="container mt-4">
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

<!--<table class="table table-striped">-->
<table>
    <thead class='table-header-cell'>
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
        <?php $index = 1; foreach ($data as $row): ?>
            <tr class='table-data-cell'>
                <td><?php echo $index; ?></td>
                <td><?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['make'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['model'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['vin'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><a href='edit.php?id=" <?php echo $row['id']; ?>"'>Edit</a></td>
                <td><a href='delete.php?id=" <?php echo $row['id']; ?>"'>Delete</a></td>
            
                <!-- Add the image upload form -->
                <td>
                    <form action='upload_image.php' method='post' enctype='multipart/form-data'>
                    <input type='file' name='vehicleImage[]' accept='image/*' multiple>
                    <input type='hidden' name='make' value='<?php echo $row['make'] ?>'>
                    <input type='hidden' name='model' value='<?php echo $row['model'] ?>'>
                    <input type='hidden' name='year' value='<?php echo $row['year'] ?>'>
                    <input type='hidden' name='vin' value='<?php echo $row['vin'] ?>'>
                    <input type='hidden' name='vehicleId' value='<?php echo $row['id'] ?>'>
                    <input type='submit' value='Upload'>
                    </form>
                </td>
            
                <!-- Image thumbnails display -->
                <?php
                    $lastFiveVin = substr($row['vin'], -5);
                    $folderName = strtolower(str_replace(' ', '-', "{$row['make']}-{$row['model']}-{$row['year']}-{$lastFiveVin}"));
                    $imgDirectory = "images/{$folderName}/";  // Assuming images are stored in an 'images' directory
                    $imgPaths = glob($imgDirectory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            
                    // Fetch image order from the database
                    $orderStmt = $pdo->prepare("SELECT image_name FROM image_order WHERE vehicle_id = ? ORDER BY position ASC");
                    $orderStmt->execute([$row['id']]);
                    $imageOrder = $orderStmt->fetchAll(PDO::FETCH_COLUMN, 0);
                ?>
            </tr>
            
            <tr>
                <td class='table-data-cell' colspan='8'>
                    <?php
                        if (!empty($imageOrder)) {
                            foreach ($imageOrder as $imageName) {
                                file_put_contents('imgOrder.txt', "\nimgDirectory: " . $imgDirectory . "\n\nImageName: " . $imageName, FILE_APPEND);
                                echo "<img src='$imageName' class='thumbnail' alt='Thumbnail'>";  // Display each image as a thumbnail
                            }
                        } else {
                            echo "No Images";
                        }
                    ?>
                </td>
            </tr>
            
            <tr class='spacer-row'>
                <td colspan='8'></td>
            </tr>

            <?php $index++;  // Increment the counter for the next row ?>
        <?php endforeach; ?>
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
