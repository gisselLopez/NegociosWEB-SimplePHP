<?php
namespace Dao\Mnt;

use Dao\Table;

class Pagos extends Table{

    public static function obtenerTodos()
    {
        $sqlstr = "select * from pagos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }

    public static function obtenerPorid($id)
    {
        $sqlstr = "select * from pagos where id=:id;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("id"=>$id)
        );
    }

    public static function nuevopago($fecha, $cliente,$monto,$fechaVencimiento,$estado)
    {
        $sqlstr= "INSERT INTO pagos (fecha, cliente,monto,fechaVencimiento, estado) values (:fecha, :cliente,:monto,:fechaVencimiento,:estado);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "fecha"=>$fecha,
                "cliente"=>$cliente,
                "monto"=>$monto,
                "fechaVencimiento"=>$fechaVencimiento,
                "estado"=>$estado
            )
        );
    }

    public static function actualizarpago($fecha, $cliente,$monto,$fechaVencimiento,$estado, $id)
    {
        $sqlstr = "UPDATE pagos set fecha=:fecha, cliente=:cliente, monto=:monto,fechaVencimiento=:fechaVencimiento,estado=:estado where id=:id";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "fecha"=>$fecha,
                "cliente"=>$cliente,
                "monto"=>$monto,
                "fechaVencimiento"=>$fechaVencimiento,
                "estado"=>$estado,
                "id"=>$id
            )
        );
    }
    public static function eliminarpago($id)
    {
        $sqlstr = "DELETE FROM pagos where id=:id;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "id"=>$id
            )
        );
    }
}
?>
