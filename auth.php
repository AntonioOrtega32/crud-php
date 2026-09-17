<?php 
//aqui va toda la logica de la atenticacion
session_start();

require 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    //aqui se evta la inyeccion de sql
    $stmt = $pdo->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario){
        //aqui se checa la contra
        if (password_verify($password, $usuario['password'])){
            //variables de la sesion
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: inicio.php");
            exit;
        }else{
            //contra incorrectq
            header("Location: index.php?error=1");
            exit; 
        }
    } else {
        //usuario que no existe
            header("Location: index.php?error=1");
            exit;
    }

}
?>