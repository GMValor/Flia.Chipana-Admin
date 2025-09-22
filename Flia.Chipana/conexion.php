<?php
class conexion{
    static function conexionBD(){

        $host='xx';
        $dbname='xx';
        $username='xx';
        $pasword='xx';
        $puerto= 1433;
        
        try {
            $conn = new PDO("sqlsrv:Server=$host,$puerto;Database=$dbname",$username,$pasword);
            echo"conexión exitosa";
        } catch (PDOException $exp) {
            echo ("Error a conectar la base de datos $dbname, error: $exp");
        }
        return $conn;
    }
}
?>