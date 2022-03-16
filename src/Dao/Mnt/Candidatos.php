<?php

namespace Dao\Mnt;

use Dao\Table;

class Candidatos extends Table
{
    public static function obtenerTodos()
    {
        $sqlstr = "select * from candidatos;";
        return self::obtenerRegistros(
            $sqlstr,
            array()
        );
    }
    public static function obtenerPorid($id)
    {
        $sqlstr = "select * from candidatos where id=:id;";
        return self::obtenerUnRegistro(
            $sqlstr,
            array("id"=>$id)
        );
    }

    public static function nuevoCandidato($identidad, $nombre,$edad)
    {
        $sqlstr= "INSERT INTO candidatos (identidad, nombre,edad) values (:identidad, :nombre, :edad);";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "identidad"=>$identidad,
                "nombre"=>$nombre,
                "edad"=>$edad
            )
        );
    }

    public static function actualizarCandidato($identidad, $nombre,$edad, $id)
    {
        $sqlstr = "UPDATE candidatos set identidad=:identidad, nombre=:nombre, edad=:edad where id=:id";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "identidad"=> $identidad,
                "nombre"=> $nombre,
                "edad"=> $edad,
                "id"=>$id
            )
        );
    }
    public static function eliminarCandidato($id)
    {
        $sqlstr = "DELETE FROM candidatos where id=:id;";
        return self::executeNonQuery(
            $sqlstr,
            array(
                "id"=>$id
            )
        );
    }
}


?>