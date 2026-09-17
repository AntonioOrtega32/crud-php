<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try { 
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        echo "Error al eliminar usuario: " . $e->getMessage();
    }
} 

header('Location: usuarios.php');
exit;
?>
