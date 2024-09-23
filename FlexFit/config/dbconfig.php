<?php

$host = 'talsprddb02.int.its.rmit.edu.au';
$dbname = 'COSC3046_2302_G4';
$user = 'COSC3046_2302_G4';
$pass = '6s8J0bplE7D6';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
