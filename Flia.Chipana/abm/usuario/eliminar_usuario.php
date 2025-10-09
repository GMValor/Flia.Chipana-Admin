<?php
require_once("../conexion.php");
$conn = Conexion::conexionBD();



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_POST["id_usuario"] ?? null;
    try {
        if ($id_usuario) {
            $sql = "EXEC spu_eliminar_usuario :id_usuario";
            $smt = $conn->prepare($sql);
            $smt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $smt->execute();

            echo "Usuario eliminado correctamente.";
            exit;
        } else {
            echo "ID no proporcionado";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}