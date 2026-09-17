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
    $telefono = $_POST['telefono'];

    try {
        // aca se evita la inyeccion de sql
        $sql = "UPDATE clientes SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            'nombre' => $nombre, 
                        'correo' => $correo, 
                        'telefono' => $telefono, 
                        'id' => $id]);

        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        echo "Error al actualizar cliente: " . $e->getMessage();
    }
}

//consulta para obtener los datos del cliente
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->execute(['id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header('Location: index.php');
    exit;
}
include 'recursos/header.php';
?>
<div class="flex items-center justify-center">
    <div class="max-w-md w-full bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Editar Cliente</h2>

        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="edit-cliente.php?id=<?php echo $cliente['id']; ?>">
            <label for="nombre">Nombre:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($cliente['nombre']); ?>" required><br><br>

            <label for="correo">Correo:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($cliente['correo']); ?>" required><br><br>

            <label for="telefono">Teléfono:</label><br>
            <input class="border border-gray-300 rounded-lg p-2" type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono']); ?>" required><br><br>

            <input class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition" type="submit" value="Actualizar cliente">
        </form>
        <a href="index.php" class="text-blue-600 hover:text-blue-800">Volver a la lista de clientes</a>
    </div>
</div>
<?php include 'recursos/footer.php'; ?>