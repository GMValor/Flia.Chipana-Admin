<?php
namespace App;

class FormasPagoRepository {
    private $pdo;  

    public function __construct() {  
        $this->pdo = Conexion::getConexion();  
    }
    
    // Mostrar todos los detalles de formas de pago
    public function obtenerTodosLosDetallesFormaDePago() {
        $stmt = $this->pdo->query("SELECT * FROM vw_mostrar_detalle_forma_pago");
        return $stmt->fetchAll();  
    }

    // Crear detalle de forma de pago
    public function crearDetalleFormaPago($data) {   
        $stmt = $this->pdo->prepare("
            EXEC spu_crear_detalle_forma_pago 
                @id_venta = :id_venta, 
                @id_forma_pago = :id_forma_pago, 
                @importe = :importe
        ");

        $stmt->bindParam(':id_venta', $data['id_venta']);
        $stmt->bindParam(':id_forma_pago', $data['id_forma_pago']);
        $stmt->bindParam(':importe', $data['importe']);

        return $stmt->execute();
    }

    // Actualizar detalle de forma de pago 
    public function actualizarDetalleFormaPago($id_venta, $id_forma_pago, $data) {
        $sql = "
            EXEC spu_modificar_detalle_forma_pago 
                @id_venta = :id_venta, 
                @id_forma_pago = :id_forma_pago, 
                @importe = :importe
        ";

        $stmt = $this->pdo->prepare($sql);

        // Construimos el array exacto que requiere el SP
        $params = [
            'id_venta'      => $id_venta,
            'id_forma_pago' => $id_forma_pago,
            'importe'       => $data['importe']
        ];

        return $stmt->execute($params);
    }

    // Eliminar detalle de forma de pago 
    public function eliminarDetalleFormaPago($id_venta, $id_forma_pago) {
        $stmt = $this->pdo->prepare("
            EXEC spu_eliminar_detalle_forma_pago 
                @id_forma_pago = :id_forma_pago,
                @id_venta = :id_venta
        ")

        return $stmt->execute([
            "id_forma_pago" => $id_forma_pago,
            "id_venta"      => $id_venta
        ]);
    }
}
