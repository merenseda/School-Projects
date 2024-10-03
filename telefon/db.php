<?php

$host = 'Your host'; 
$dbname = 'Your Database Name';
$username = 'Your username'; 
$password = 'Yoyr password (Optional)';     

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Veritabanı bağlantı hatası: " . $e->getMessage();
    exit;
}
?>
