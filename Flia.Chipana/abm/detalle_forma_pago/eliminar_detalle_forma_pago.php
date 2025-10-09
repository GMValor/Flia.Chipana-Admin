<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_venta = $_POST["id_venta"] ?? null;
    $id_forma_pago = $_POST["id_forma_pago"] ?? null;
    try {
        if ($id_venta && $id_forma_pago) {
            $sql = "EXEC spu_eliminar_detalle_forma_pago :id_venta , :id_forma_pago";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
            $smt->bindParam(':id_forma_pago', $id_forma_pago, PDO::PARAM_INT);
            $smt->execute();

            echo "Detalle de forma de pago eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}