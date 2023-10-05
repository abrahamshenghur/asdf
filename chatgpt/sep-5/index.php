<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Database</title>
    <style>
        #vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
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

$stmt = $pdo->query("SELECT id, year, make, model FROM vehicles_test");
$data = $stmt->fetchAll();
?>

<form action="add.php" method="post">
    Year: <input type="text" name="year"><br>
    Make: <input type="text" name="make"><br>
    Model: <input type="text" name="model"><br>
    <input type="submit" value="Add Vehicle">
</form>

<table>
    <thead>
        <tr>
            <th>Year</th>
            <th>Make</th>
            <th>Model</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['make'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>";
            echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<div id="vehicle-grid">
    <?php
    foreach ($data as $row) {
        echo '<div class="grid-item" data-id="' . $row['id'] . '">';
        echo '<label>Year: ' . $row['year'] . '</label><br>';
        echo '<label>Make: ' . $row['make'] . '</label><br>';
        echo '<label>Model: ' . $row['model'] . '</label>';
        echo '</div>';
    }
    ?>
</div>

<script>
    // new Sortable(document.getElementById('vehicle-grid'), {
    //     animation: 150
    // });
    
    var vehicleGrid = document.getElementById('vehicle-grid');
    // new Sortable(vehicleGrid, {
    //     animation: 150,
    //     onUpdate: function(evt) {
    //         var itemOrder = [];
    //         vehicleGrid.querySelectorAll('.grid-item').forEach(function(item) {
    //             itemOrder.push(item.getAttribute('data-id'));
    //         });
    //         updateDatabaseOrder(itemOrder);
    //     }
    // });
    
    new Sortable(vehicleGrid, {
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
    
    // function updateDatabaseOrder(order) {
    //     console.log("Sending order to server:", order);
        
    //     fetch('update_order.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify({ order: order })
    //     })
    //     .then(response => response.text())
    //     .then(data => {
    //         console.log("Server Response:", data);
    //     });
    // }
    
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
                console.log("Order updated successfully!");
            } else {
                console.error("Failed to update order:", data.error);
            }
        });
    }

</script>

</body>
</html>
