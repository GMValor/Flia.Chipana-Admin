<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_venta = $_POST["id_venta"] ?? null;
    try {
        if ($id_venta) {
            $sql = "EXEC spu_eliminar_venta :id_venta";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_producto', $id_venta, PDO::PARAM_INT);
            $smt->execute();

            echo "Venta eliminada correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}