<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];


    try {
        // aca se evita la inyeccion de sql
        $sql = "INSERT INTO clientes (nombre, correo, telefono) VALUES (:nombre, :correo, :telefono)";
        $stmt = $pdo->prepare($sql);

        // ejecuta el sql

        $stmt->execute(['nombre' => $nombre, 
        'correo' => $correo, 
        'telefono' => $telefono]);

        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        echo "Error al agregar cliente: " . $e->getMessage();
    }
  
}


include 'recursos/header.php';
?>
<div class="flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Agregar Cliente</h2>
        <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>

        <h1>Agregar nuevo cliente</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="create-cliente.php">
            <label for="nombre">Nombre:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="nombre" name="nombre" required><br><br>

            <label for="correo">Correo:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="email" id="correo" name="correo" required><br><br>

            <label for="telefono">Teléfono:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="telefono" name="telefono" required><br><br>

            <input class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition" type="submit" value="Agregar cliente">
        </form>
        <br>
        <a href="index.php"class="text-blue-600 hover:text-blue-800">Volver a la lista de clientes</a>
    </div>
</div>
<?php include 'recursos/footer.php'; ?>
