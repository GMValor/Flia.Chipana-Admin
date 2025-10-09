<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_proveedor = $_POST["id_proveedor"] ?? null;
    try {
        if ($id_proveedor) {
            $sql = "EXEC spu_eliminar_proveedor :id_proveedor";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
            $smt->execute();

            echo "Proveedor eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}