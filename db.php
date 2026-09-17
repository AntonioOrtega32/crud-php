<?php
$host = '127.0.0.1';
$db = 'crud_db';
$username = 'root';
$password = '';


try {
    //conexion a bd 
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "No se puede conectar: " . $e->getMessage();
}
?>