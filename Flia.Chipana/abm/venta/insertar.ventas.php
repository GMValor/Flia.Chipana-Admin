<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_venta = $_POST["id_venta"];
    $id_usuario = $_POST["id_usuario"];
    $fecha = $_POST["fecha"];
    $id_cliente = $_POST["id_cliente"];
    $total = $_POST["direccion"];
    $descuento = $_POST["descuento"];

    try {
        $sql = "EXEC spu_crear_cliente 
                @id_venta = ?, @id_usuario = ?, @fecha = ?, @id_cliente = ?, @total = ?,@descuento = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_proveedor, $nombre, $telefono, $email, $direccion]);

        echo json_encode(['success' => true, 'message' => 'Venta agregado correctamente']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

