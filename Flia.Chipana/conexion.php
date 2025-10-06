<?php
class Conexion {
    public static function conexionBD() {   //cambio a clase estatica para no tener que intanciarla
        $host = 'PC-KchJ';
        $dbname = 'fliachipana';
        $username = 'su';
        $password = 'peras2004';
        $puerto = 1433;

        try {
            $conn = new PDO("sqlsrv:Server=$host,$puerto;Database=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //atrapar errores de sql de forma controlada
        } catch (PDOException $exp) {
            echo "Error a conectar la base de datos $dbname, error: " . $exp->getMessage();
        }
        return $conn;
    }
}
?>
