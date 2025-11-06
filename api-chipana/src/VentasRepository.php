<?php
namespace App;
class VentasRepository {
    private $pdo;  

    public function __construct() {  //funcion que se ejecuta automaticamente y guardar la conexion para poder usarla en los metodos
    $this->pdo = Conexion::getConexion();   //conexion estatica
}

    // Mostrar todos los venta
    public function obtenerTodasLasVentas() {
        $stmt = $this->pdo->query("SELECT * FROM vw_mostrar_ventas");
        return $stmt->fetchAll();  //devuelve todo los registros (array) de la consulata
    }

    // Crear venta
    public function crearVenta($data) {   //data se llena desde el index en el post
        // Obtener el ID más alto actual
     $stmt = $this->pdo->query("SELECT MAX(id_venta) AS max_id FROM ventas");
    $maxIdRow = $stmt->fetch(\PDO::FETCH_ASSOC);
    $nuevoId = ($maxIdRow['max_id'] ?? 0) + 1;

    $stmt = $this->pdo->prepare("EXEC spu_crear_venta @id_venta =:id_venta, @id_usuario = :id_usuario, @fecha = :fecha, @id_cliente = :id_cliente, @total = :total, @descuento = :descuento");

    $stmt->bindParam(':id_venta', $nuevoId);
    $stmt->bindParam(':id_usuario', $data['id_usuario']);
    $stmt->bindParam(':fecha', $data['fecha']);
    $stmt->bindParam(':id_cliente', $data['id_cliente']);
    $stmt->bindParam(':total', $data['total']);
    $stmt->bindParam(':descuento', $data['descuento']);
     
  return $stmt->execute();
    }

    // Actualizar venta
    public function actualizarVenta($id_venta, $data) {
        $sql = "EXEC spu_modificar_venta @id_venta =:id_venta, @id_usuario = :id_usuario, @fecha = :fecha, @id_cliente = :id_cliente, @total = :total, @descuento = :descuento";
        $stmt = $this->pdo->prepare($sql);

        $data["id_venta"] = $id_venta; //agregar el id de la venta en el array y luego se ejecuta todo
        return $stmt->execute($data);
    }

    // Eliminar venta
    public function eliminarVenta($id_venta) {
        $stmt = $this->pdo->prepare("EXEC spu_eliminar_venta @id_venta = :id_venta");
        return $stmt->execute(["id_venta" => $id_venta]);
    }
}