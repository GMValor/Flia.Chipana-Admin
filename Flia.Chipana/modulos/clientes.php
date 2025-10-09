<?php
require_once("../conexion.php");

// Conectar a la base de datos
$conn = Conexion::conexionBD();

// Consultar clientes
$sql = "SELECT * FROM vw_mostrar_clientes";
$stmt = $conn->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



    <!-- CONTENEDOR PRINCIPAL -->
<div class="module-container">

    <!-- HEADER -->
    <div class="module-header">
        <h2>CLIENTES</h2>
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
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Deuda</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id_cliente']) ?></td>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><?= htmlspecialchars($c['apellido']) ?></td>
                <td><?= htmlspecialchars($c['telefono']) ?></td>
                <td><?= htmlspecialchars($c['direccion']) ?></td>
                <td><?= htmlspecialchars($c['email'] ) ?></td>
                <td><?= htmlspecialchars($c['deuda'] ) ?></td>
                <td class="actions">
                    <button class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                    <button class="btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>



<!-- PANEL LATERAL AGREGAR-->
<div id="overlay" class="overlay"></div>
<div id="panel-agregar" class="side-panel">
    <div class="side-panel-header">
        <h3><i class="fa-solid fa-user-plus"></i> Agregar Nuevo Cliente</h3>
        <button id="btn-cerrar-panel" class="btn-close">&times;</button>
    </div>
    <form id="form-agregar-cliente" class="form-agregar">
        <input type="number" name="id_cliente" placeholder="ID" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="email" name="email" placeholder="Email"  required>
        <input type="number" name="deuda" placeholder="Deuda">

        <button type="submit" class="btn-submit">Agregar</button>
    </form>
</div>





