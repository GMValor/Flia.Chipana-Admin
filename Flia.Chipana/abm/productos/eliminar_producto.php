<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_producto = $_POST["id_producto"] ?? null;
    try {
        if ($id_cliente) {
            $sql = "EXEC spu_eliminar_producto :id_producto";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $smt->execute();

            echo "Producto eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}