<?php
require_once("../conexion.php");

// Conectar a la base de datos
$conn = Conexion::conexionBD();

// Consultar clientes (opcional: you could fetch one client to prefill the form)
$sql = "SELECT * FROM clientes"; // or a specific client if you want
$stmt = $conn->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- CONTENEDOR PRINCIPAL -->
<div class="module-container">

    <!-- HEADER -->
    <div class="module-header">
        <h2>Actualizar Cliente</h2>
        <div class="search-add">
            <input type="text" placeholder="Buscar cliente" class="search-bar">
            <button class="btn-add">Agregar cliente</button>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="form-container">
        <form method="POST" action="modificar_cliente.php" class="custom-form">
            
            <label>ID Cliente:
                <input type="number" name="id_cliente" value="<?= htmlspecialchars($clientes[0]['id_cliente'] ?? '') ?>" required>
            </label><br><br>

            <label>Nombre:
                <input type="text" name="nombre" value="<?= htmlspecialchars($clientes[0]['nombre'] ?? '') ?>" required>
            </label><br><br>

            <label>Apellido:
                <input type="text" name="apellido" value="<?= htmlspecialchars($clientes[0]['apellido'] ?? '') ?>" required>
            </label><br><br>

            <label>Teléfono:
                <input type="text" name="telefono" value="<?= htmlspecialchars($clientes[0]['telefono'] ?? '') ?>">
            </label><br><br>

            <label>Dirección:
                <input type="text" name="direccion" value="<?= htmlspecialchars($clientes[0]['direccion'] ?? '') ?>">
            </label><br><br>

            <label>Email:
                <input type="email" name="email" value="<?= htmlspecialchars($clientes[0]['email'] ?? '') ?>">
            </label><br><br>

            <label>Deuda:
                <input type="number" step="0.01" name="deuda" value="<?= htmlspecialchars($clientes[0]['deuda'] ?? 0) ?>">
            </label><br><br>

            <button type="submit" class="btn-update">Actualizar Cliente</button>
        </form>
    </div>

    <!-- TABLA DE CLIENTES -->
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
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['deuda']) ?></td>
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
