<?php
$servername = "mysql:host=localhost;dbname=s148804";
$username = "s148804";
$password = "4OsiGh!wj2oR";

try {
    $conn = new PDO($servername, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Połączenie nieudane: " . $e->getMessage();
}
