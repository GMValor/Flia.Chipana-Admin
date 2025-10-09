<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_forma_pago = $_POST["id_forma_pago"];
    $descripcion = $_POST["descripcion"];
    try {
        $sql = "EXEC spu_crear_forma_pago 
                @id_forma_pago = ?, @descripcion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_forma_pago, $descripcio]);

        echo json_encode(['success' => true, 'message' => 'forma de pago agregada correctamente']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
