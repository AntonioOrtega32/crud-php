<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])){
    header("Location: index.php?error=2");
}

$nombreUsuario = $_SESSION['nombre'];
$rolUsuario = $_SESSION['rol'];

//consulta para los clientes
$stmt = $pdo->query("SELECT * FROM clientes ORDER BY fecha_registro DESC");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
include 'recursos/header.php';
?>
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">


<!-- titulo y rol actual de usuario -->
    <div class="flex justify-between items-center mb-6">
        
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Tabla de clientes</h2>
            <p class="text-sm text-gray-500">Rol actual: <span class="font-bold text-blue-600"><?php echo htmlspecialchars($rolUsuario); ?></span></p>
            <p class="text-sm text-gray-500">Usuario: <span class="font-bold text-green-600"><?php echo htmlspecialchars($nombreUsuario); ?></span></p>
        </div>

        <!-- boton de crear cliente solo para admin y ventas y tambien de cerrar sesion -->
        <?php if ($rolUsuario === 'Admin' || $rolUsuario === 'Ventas'):?>
        
        <a href="create-cliente.php" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            Agregar Nuevo Cliente</a>

        <?php endif; ?>

        <!-- ir a la tabla de usuarios sol para admin -->
         <?php if ($rolUsuario === 'Admin'):?>
         <a href="usuarios.php" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg transition">
            Ir a tabla usuarios</a>
         <?php endif; ?>

        <div class="flex items-center space-x-4">
            <a href="salir.php" class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-3 py-1.5 rounded transition">
                Cerrar Sesión
            </a>
        </div>
        
     </div>

     <div class="overflow-x-auto">
        <table id="TbClientes" class="auto min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cliente['id']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                        <td>
                        <!-- los usarios de finanzas no pueden modificar los clientes -->
                            <?php if ($rolUsuario === 'Admin' || $rolUsuario === 'Ventas'):?>
                            <a class="text-blue-600 hover:text-blue-800" href="edit-cliente.php?id=<?php echo $cliente['id']; ?>">Editar</a> |
                            <a class="text-red-600 hover:text-red-800" href="delete-cliente.php?id=<?php echo $cliente['id']; ?>" onclick="return confirm('Eliminar cliente?');">Eliminar</a>
                            <?php else:?>
                                Finanzas no puede modificar
                            <?php endif; ?>      
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
            $('#TbClientes').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            }
            });
        });
        </script>

    <?php include 'recursos/footer.php'; ?>