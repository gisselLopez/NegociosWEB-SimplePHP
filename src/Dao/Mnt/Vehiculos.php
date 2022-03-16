<?php

namespace Dao\Mnt;

use Dao\Table;

class Vehiculos extends Table
{
    public static function obtenerTodos()
    {
        $sqlstr = "select * from vehiculos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }
    public static function obtenerPorid($id)
    {
        $sqlstr = "select * from vehiculos where id=:id;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("id"=>$id)
        );
    }

    public static function nuevovehiculo($marca, $modelo,$color,$estado)
    {
        $sqlstr= "INSERT INTO vehiculos (marca,modelo,color,estado) values (:marca,:modelo,:color, :estado);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "marca"=>$marca,
                "modelo"=>$modelo,
                "color"=>$color,
                "estado"=>$estado
                
            )
        );
    }

    public static function actualizarvehiculo($marca, $modelo,$color, $estado, $id)
    {
        $sqlstr = "UPDATE vehiculos set marca=:marca,  modelo=:modelo, color=:color,estado=:estado where id=:id";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "marca"=>$marca,
                "modelo"=>$modelo,
                "color"=>$color,
                "estado"=>$estado,
                "id"=>$id
            )
        );
    }
    public static function eliminarvehiculo($id)
    {
        $sqlstr = "DELETE FROM vehiculos where id=:id;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "id"=>$id
            )
        );
    }
}


?>