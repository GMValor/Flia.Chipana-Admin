<?php   
require_once("../conexion.php");
$conn = Conexion::conexionBD();

header('Content-Type: application/json');

   

 $id_cliente = $_POST["id_cliente"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $email = $_POST["email"];
    $deuda = $_POST["deuda"];

 if (!$id_cliente) {
        throw new Exception("El ID del cliente es obligatorio.");
    }
    $stmt = $conn->prepare($sql);

try {
    $sql = "EXEC spu_modificar_cliente 
 @id_cliente = ?, @nombre = ?, @apellido = ?, @telefono = ?, @direccion = ?, @email = ?, @deuda = ?";
 $stmt = $conn->prepare($sql);
$stmt->execute([$id_cliente, $nombre, $apellido, $telefono, $direccion, $email, $deuda]);
 echo json_encode(['success' => true, 'message' => 'Cliente agregado correctamente']);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
}


