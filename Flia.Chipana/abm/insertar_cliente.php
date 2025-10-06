<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id_cliente = $_POST["id_cliente"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $email = $_POST["email"];
    $deuda = $_POST["deuda"];

    try {
        $sql = "EXEC spu_crear_cliente 
                @id_cliente = ?, @nombre = ?, @apellido = ?, @telefono = ?, @direccion = ?, @email = ?, @deuda = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id_cliente, $nombre, $apellido, $telefono, $direccion, $email, $deuda]);

        echo json_encode(['success' => true, 'message' => 'Cliente agregado correctamente']);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
