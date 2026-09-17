<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try { 
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        echo "Error al eliminar cliente: " . $e->getMessage();
    }
} 

header('Location: inicio.php');
exit;
?>
