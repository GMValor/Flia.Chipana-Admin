<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_cliente = $_POST["id_cliente"] ?? null;
    try {
        if ($id_cliente) {
            $sql = "EXEC spu_eliminar_cliente :id_cliente";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $smt->execute();

            echo "Cliente eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
