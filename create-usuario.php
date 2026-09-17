<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    //aqui hashea la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    try {
        // aca se evita la inyeccion de sql
        $sql = "INSERT INTO usuarios (nombre, correo, password,  rol) VALUES (:nombre, :correo, :password, :rol)";
        $stmt = $pdo->prepare($sql);

        // ejecuta el sql

        $stmt->execute([
        'nombre' => $nombre, 
        'correo' => $correo,
        'password' => $passwordHash,
        'rol' => $rol]
        );

        header('Location: usuarios.php');
        exit;
    } catch (PDOException $e) {
        echo "Error al agregar usuario: " . $e->getMessage();
    }
  
}


include 'recursos/header.php';
?>
<div class="flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Agregar Usuario</h2>
        <?php if (isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>

        <h1>Agregar nuevo cliente</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="create-usuario.php">
            <label for="nombre">Nombre:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="nombre" name="nombre" required><br><br>

            <label for="correo">Correo:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="email" id="correo" name="correo" required><br><br>

            <label for="contraseña">Contraseña:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="password" name="password" required><br><br>

            <label for="rol">Rol</label><br>
             <select id="rol" name="rol" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                <option selected>Escoge un rol</option>
                <option value="Admin">Admin</option>
                <option value="Ventas">Ventas</option>
                <option value="Finanzas">Finanzas</option>
            </select>
            <br><br>

            <input class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition" type="submit" value="Agregar usuario">
        </form>
        <br>
        <a href="usuarios.php"class="text-blue-600 hover:text-blue-800">Volver a la lista de usuarios</a>
    </div>
</div>
<?php include 'recursos/footer.php'; ?>
