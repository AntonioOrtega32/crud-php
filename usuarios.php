<?php
session_start();
require 'db.php';

//aqui si el ususario no esta logeado o es admin no puede entrar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Admin') {
    header("Location: index.php?error=2");
    exit();
}

$nombreUsuario = $_SESSION['nombre'];
$rolUsuario = $_SESSION['rol'];

//consulta para los usuarios
$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
include 'recursos/header.php';
?>
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">


<!-- titulo y rol actual de usuario -->
    <div class="flex justify-between items-center mb-6">
        
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tabla de usuarios</h2>
            <p class="text-sm text-gray-500">Rol actual: <span class="font-bold text-blue-600"><?php echo htmlspecialchars($rolUsuario); ?></span></p>
            <p class="text-sm text-gray-500">Usuario: <span class="font-bold text-green-600"><?php echo htmlspecialchars($nombreUsuario); ?></span></p>
        </div>

        <!-- boton de crear usuario -->   
        <a href="create-usuario.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            Agregar Nuevo Usuario</a>

        <!-- ir a la tabla de clientes -->
         <a href="inicio.php" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            Ir a tabla clientes</a>

        <div class="flex items-center space-x-4">
            <a href="salir.php" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-3 py-1.5 rounded transition">
                Cerrar Sesión
            </a>
        </div>
        
     </div>

     <div class="overflow-x-auto">
        <table id="TbUsuarios" class="auto min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td>
                            <a class="text-blue-600 hover:text-blue-800" href="edit-usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a> |
                            <a class="text-red-600 hover:text-red-800" href="eliminar-usuario.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('Eliminar usuario?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
     </div>
        </div>

        <!-- codigo de datatable -->
        <script>
        $(document).ready(function() {
            $('#TbUsuarios').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
            });
        });
        </script>

    <?php include 'recursos/footer.php'; ?>