<?php
require_once("../conexion.php");

// Conectar a la base de datos
$conn = Conexion::conexionBD();

// Consultar clientes
$sql = "SELECT * FROM vw_mostrar_productos";
$stmt = $conn->query($sql);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



    <!-- CONTENEDOR PRINCIPAL -->
<div class="module-container">

    <!-- HEADER -->
    <div class="module-header">
        <h2>PRODUCTOS</h2>
        <div class="search-add">
            <input type="text" placeholder="Buscar Producto" class="search-bar">
            <button class="btn-add">Agregar items</button>
        </div>
    </div>

    <!-- TABLA -->
    <div class="table-scroll-container">

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>ID Proveedor</th>
                <th>Precio</th>
                <th>Costo</th>
                <th>Fecha Caducidad</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['id_producto']) ?></td>
                <td><?= htmlspecialchars($p['descripcion']) ?></td>
                <td><?= htmlspecialchars($p['stock']) ?></td>
                <td><?= htmlspecialchars($p['id_proveedor']) ?></td>
                <td><?= htmlspecialchars($p['precio']) ?></td>
                <td><?= htmlspecialchars($p['costo'] ) ?></td>
                <td><?= htmlspecialchars($p['fecha_cad'] ) ?></td>
                <td class="actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>