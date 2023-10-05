
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>
<body>

<form action="add.php" method="post">
    Year: <input type="text" name="year"><br>
    Make: <input type="text" name="make"><br>
    Model: <input type="text" name="model"><br>
    VIN: <input type="text" name="vin"><br> <!-- New input field for VIN -->
    <input type="submit" value="Add Vehicle">
</form>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>VIN</th> <!-- New column header for VIN -->
            <th>Edit</th>
            <th>Delete</th>
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
            echo "<td>" . htmlspecialchars($row['vin'], ENT_QUOTES, 'UTF-8') . "</td>"; //<!-- Display the VIN -->
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>";
            echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
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
        echo '<label># ' . $gridIndex . '</label><br>';  // Display the grid index
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

</body>
</html>
