<?php

namespace Dao\Mnt;

use Dao\Table;

class LugaresTuristicos extends Table
{
    public static function obtenerTodos()
    {
        $sqlstr = "select * from lugaresturisticos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }
    public static function obtenerPorLugarId($lugarid)
    {
        $sqlstr = "select * from lugaresturisticos where lugarid=:lugarid;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("lugarid"=>$lugarid)
        );
    }

    public static function nuevoLugarTuristco($lugar, $pais, $estado, $ciudad, $latitud, $longitud)
    {
        $sqlstr= "INSERT INTO lugaresturisticos (lugar, pais, estado, ciudad, latitud, longitud) values (:lugar, :pais, :estado, :ciudad, :latitud, :longitud);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugar"=>$lugar,
                "pais"=>$pais,
                "estado"=>$estado,
                "ciudad"=>$ciudad,
                "latitud"=>$latitud,
                "longitud"=>$longitud
            )
        );
    }

    public static function actualizarLugarTuristco($lugar, $pais, $estado, $ciudad, $latitud, $longitud, $lugarid)
    {
        $sqlstr = "UPDATE lugaresturisticos set lugar=:lugar, pais=:pais, estado=:estado, ciudad=:ciudad, latitud=:latitud, longitud=:longitud where lugarid=:lugarid";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugar"=>$lugar,
                "pais"=>$pais,
                "estado"=>$estado,
                "ciudad"=>$ciudad,
                "latitud"=>$latitud,
                "longitud"=>$longitud,
                "lugarid"=>$lugarid
            )
        );
    }
    public static function eliminarLugarTuristco($lugarid)
    {
        $sqlstr = "DELETE FROM lugaresturisticos where lugarid=:lugarid;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "lugarid"=>$lugarid
            )
        );
    }
}


?>
