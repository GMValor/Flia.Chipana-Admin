<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_venta = $_POST["id_venta"] ?? null;
    $id_producto = $_POST["id_producto"] ?? null;
    try {
        if ($id_venta && $id_producto) {
            $sql = "EXEC spu_eliminar_detalle_venta :id_producto, :id_venta";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
            $smt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            $smt->execute();

            echo "Detalle de venta eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}