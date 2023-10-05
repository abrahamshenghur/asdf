
<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Database</title>
</head>
<body>

<form action="add.php" method="post">
    Year: <input type="text" name="year"><br>
    Make: <input type="text" name="make"><br>
    Model: <input type="text" name="model"><br>
    <input type="submit" value="Add Vehicle">
</form>

<!-- Placeholder for table displaying current data -->
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
        <!-- This will be populated with PHP -->
    </tbody>
</table>

</body>
</html>
