<?php
namespace App;
class DetalleVentaRepository {
    private $pdo;  

    public function __construct() {  //funcion que se ejecuta automaticamente y guardar la conexion para poder usarla en los metodos
    $this->pdo = Conexion::getConexion();   //conexion estatica
}

    // Mostrar todos los detalles de venta
    public function obtenerTodosLosDetallesVenta() {
        $stmt = $this->pdo->query("SELECT * FROM vw_mostrar_detalle_venta");
        return $stmt->fetchAll();  //devuelve todo los registros (array) de la consulata
    }

    // Crear detalle de venta
    public function crearDetalleVenta($data) {   //data se llena desde el index en el post
        // Obtener el ID más alto actual
     $stmt = $this->pdo->query("SELECT MAX(id_venta) AS max_id FROM detalle_venta");
    $maxIdRow = $stmt->fetch(\PDO::FETCH_ASSOC);
    $nuevoId = ($maxIdRow['max_id'] ?? 0) + 1;

    $stmt = $this->pdo->prepare("EXEC spu_crear_detalle_venta  @id_venta =:id_venta, @id_producto = :id_producto, @precio_total = :precio_total, @cantidad = :cantidad, @precio = :precio");

    $stmt->bindParam(':id_venta', $nuevoId);
    $stmt->bindParam(':id_producto', $data['id_producto']);
    $stmt->bindParam(':precio_total', $data['precio_total']);
    $stmt->bindParam(':cantidad', $data['cantidad']);
    $stmt->bindParam(':precio', $data['precio']);

     
  return $stmt->execute();
    }

    // Actualizar forma de pago
    public function actualizarDetalleVenta($id_venta, $data) {
        $sql = "EXEC spu_modificar_detalle_venta @id_venta =:id_venta, @id_producto = :id_producto, @precio_total = :precio_total, @cantidad = :cantidad, @precio = :precio";
        $stmt = $this->pdo->prepare($sql);

        $data["@id_venta"] = $id_venta; //agregar el id de la forma de pago en el array y luego se ejecuta todo
        return $stmt->execute($data);
    }

    // Eliminar forma de pago
    public function eliminarDetalleVenta($id_venta) {
        $stmt = $this->pdo->prepare("EXEC spu_eliminar_detalle_venta @id_venta =:@id_venta, @id_producto =:id_producto");
        return $stmt->execute(["id_venta" => $id_venta]);
        return $stmt->execute(["id_producto" => $id_producto]);
    }
}