<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}

//trae el id del registro en la url
if (!isset($_GET['id'])) {
    header('Location: inicio.php');
    exit;
}

$id = $_GET['id'];

//para el formulario de actualizacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    try {
        // si se ingreso una nueva contraseña
        if (!empty($password)) {
            // aqui se hashea la nueva contraseña
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, password = :password, rol = :rol WHERE id = :id";
            $params = [
                'nombre' => $nombre, 
                'correo' => $correo, 
                'password' => $passwordHash, 
                'rol' => $rol, 
                'id' => $id
            ];
        } 
         // en caso de qeu se deje vacio el campo se actualiza lo demas menos la contraseña
        else {
            $sql = "UPDATE usuarios SET nombre = :nombre, correo = :correo, rol = :rol WHERE id = :id";
            $params = [
                'nombre' => $nombre, 
                'correo' => $correo, 
                'rol' => $rol, 
                'id' => $id
            ];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        header('Location: usuarios.php');
        exit;

    } catch (PDOException $e) {
        echo "Error al actualizar usuario: " . $e->getMessage();
    }
}

//consulta para traer los datos del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}
include 'recursos/header.php';
?>
<div class="flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Editar Usuario</h2>

        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="edit-usuario.php?id=<?php echo $usuario['id']; ?>">
            <label for="nombre">Nombre:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br><br>

            <label for="correo">Correo:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br><br>

            <label for="password">Contraseña:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="password" name="password">
            <p class="text-xs text-gray-500 mt-1">Dejar en blanco para mantener la contraseña actual.</p>
            <br>

            <label for="rol">Rol:</label><br>
            <select id="rol" name="rol" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Admin" <?php echo ($usuario['rol'] === 'Admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="Ventas" <?php echo ($usuario['rol'] === 'Ventas') ? 'selected' : ''; ?>>Ventas</option>
                    <option value="Finanzas" <?php echo ($usuario['rol'] === 'Finanzas') ? 'selected' : ''; ?>>Finanzas</option>
                </select>
            <br><br>

            <input class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition" type="submit" value="Actualizar usuario">
        </form>
        <a href="usuarios.php" class="text-blue-600 hover:text-blue-800">Volver a la lista de usuarios</a>
    </div>
</div>
<?php include 'recursos/footer.php'; ?>