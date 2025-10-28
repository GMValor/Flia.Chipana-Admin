<?php
namespace App;
class ConsultasRepository {
    private $pdo;  

    public function __construct() {  //funcion que se ejecuta automaticamente y guardar la conexion para poder usarla en los metodos
    $this->pdo = Conexion::getConexion();   //conexion estatica
}
    public function obtenerTodosLosProductosConProveedores() {
        $stmt = $this->pdo->query("SELECT * FROM vw_listado_productos_proveedor");
        return $stmt->fetchAll();  //devuelve todo los registros (array) de la consulta
}

    public function productoMasVendido($fecha_desde, $fecha_hasta) {
        $sql = "EXEC spu_producto_mas_vendido_por_fecha @fecha_desde =:fecha_desde, @fecha_hasta = :fecha_hasta";
        $stmt = $this->pdo->prepare($sql);

        $fecha_desde = date('d-m-Y', strtotime($fecha_desde));
        $fecha_hasta = date('d-m-Y', strtotime($fecha_hasta));


// Asignar los parámetros
        $stmt->bindParam(':fecha_desde', $fecha_desde, \PDO::PARAM_STR);
        $stmt->bindParam(':fecha_hasta', $fecha_hasta, \PDO::PARAM_STR);

    // Ejecutar y retornar los resultados
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
}

    public function ventaPorFecha($fecha_desde, $fecha_hasta) {
        $sql = "EXEC spu_filtrar_venta_por_fecha @fecha_desde =:fecha_desde, @fecha_hasta = :fecha_hasta";
        $stmt = $this->pdo->prepare($sql);

        $fecha_desde = date('d-m-Y', strtotime($fecha_desde));
        $fecha_hasta = date('d-m-Y', strtotime($fecha_hasta));


// Asignar los parámetros
        $stmt->bindParam(':fecha_desde', $fecha_desde, \PDO::PARAM_STR);
        $stmt->bindParam(':fecha_hasta', $fecha_hasta, \PDO::PARAM_STR);

    // Ejecutar y retornar los resultados
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
}

    public function productoPorProveedor($id_proveedor) {
        $sql = "EXEC spu_filtrar_producto_por_proveedor @id_proveedor = :id_proveedor";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':id_proveedor', $id_proveedor, \PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

    public function productosFechaCaducidad($fecha_desde, $fecha_hasta) {
        $sql = "EXEC spu_filtrar_producto_por_fecha_caducidad @fecha_desde =:fecha_desde, @fecha_hasta = :fecha_hasta";
        $stmt = $this->pdo->prepare($sql);

        $fecha_desde = date('d-m-Y', strtotime($fecha_desde));
        $fecha_hasta = date('d-m-Y', strtotime($fecha_hasta));


// Asignar los parámetros
        $stmt->bindParam(':fecha_desde', $fecha_desde, \PDO::PARAM_STR);
        $stmt->bindParam(':fecha_hasta', $fecha_hasta, \PDO::PARAM_STR);

    // Ejecutar y retornar los resultados
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
}
}