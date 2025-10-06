<?php
require_once("../conexion.php");

// Conectar a la base de datos
$conn = Conexion::conexionBD();

// Consultar clientes
$sql = "SELECT * FROM vw_mostrar_proveedores";
$stmt = $conn->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



    <!-- CONTENEDOR PRINCIPAL -->
<div class="module-container">

    <!-- HEADER -->
    <div class="module-header">
        <h2>PROVEEDORES</h2>
        <div class="search-add">
            <input type="text" placeholder="Buscar cliente" class="search-bar">
            <button class="btn-add">Agregar items</button>
        </div>
    </div>

    <!-- TABLA -->
    <div class="table-scroll-container">

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id_proveedor']) ?></td>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><?= htmlspecialchars($c['telefono']) ?></td>
                <td><?= htmlspecialchars($c['email'] ) ?></td>
                <td><?= htmlspecialchars($c['direccion']) ?></td>
                <td class="actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>