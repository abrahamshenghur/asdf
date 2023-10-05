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
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


try {
    // Check if the position column exists
    $stmt = $pdo->prepare("SHOW COLUMNS FROM vehicles_test LIKE 'position'");
    $stmt->execute();
    
    // If the position column doesn't exist, add it
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("ALTER TABLE vehicles_test ADD position INT DEFAULT 0");
        $stmt->execute();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
