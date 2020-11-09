<?php
class accesos_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function verificarInicioSesion($usuario,$clave)
    {
        $sql = "SELECT * FROM accesos WHERE usuario='$usuario' AND clave='$clave'";

        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    }

    function agregar($usuario,$clave)
    {
        $sql = "INSERT INTO accesos (usuario, clave) VALUES ('$usuario','$clave')";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }

    function seleccionar($atributo='',$valor='')
    {
        $condicion="";
        
        if($atributo && $valor)
        {
            $condicion = " WHERE $atributo='$valor'";
        }

        $sql = "SELECT * FROM accesos $condicion";
        
        $this->conexion->consulta($sql);

        $arreglo_accesos=$this->conexion->extraerRegistro();

        return $arreglo_accesos;
    }

    function actualizar($id_accesos,$clave)
    {
        $sql = "UPDATE accesos SET clave='$clave' WHERE id_accesos='$id_accesos'";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }
}
?>