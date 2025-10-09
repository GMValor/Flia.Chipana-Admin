<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_proveedor = $_POST["id_proveedor"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];

    try {
        $sql = "EXEC spu_crear_cliente 
                @id_proveedor = ?, @nombre = ?, @telefono = ?, @email = ?, @direccion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_proveedor, $nombre, $telefono, $email, $direccion]);

        echo json_encode(['success' => true, 'message' => 'Proveedor agregado correctamente']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

