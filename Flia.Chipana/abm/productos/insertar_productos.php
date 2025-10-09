<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_producto = $_POST["id_producto"];
    $descripcion = $_POST["descripcion"];
    $stock = $_POST["stock"];
    $id_proveedor = $_POST["id_proveedor"];
    $precio = $_POST["precio"];
    $costo = $_POST["costo"];
    $fecha_cad = $_POST["fecha_cad"];

    try {
        $sql = "EXEC spu_crear_producto 
                @id_producto = ?, @descripcion = ?, @stock = ?, @id_proveedor = ?, @precio = ?, @costo = ?, @fecha_cad = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_producto, $descripcion, $stock, $id_proveedor, $precio, $costo, $fecha_cad]);

        echo json_encode(['success' => true, 'message' => 'Producto agregado correctamente']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

