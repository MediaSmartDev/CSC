<?php
$host = 'localhost'; // Change this to your database host
$dbname = 'cscdz9818_pitanco'; // Change this to your database name
$username = 'cscdz9818_kia'; // Change this to your database username
$password = 'Lovisca.com#2904'; // Change this to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
