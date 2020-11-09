<?php
class personas_MO
{
    private $conexion;

    function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    function listarPersonas()
    {
        $sql = "SELECT * FROM personas";

        $this->conexion->consulta($sql);

        $arreglo_personas=$this->conexion->extraerRegistro();

        return $arreglo_personas;
    }

    function seleccionarPorPersonas($documento)
    {
        $sql = "SELECT * FROM personas WHERE documento='$documento'";

        $this->conexion->consulta($sql);

        $arreglo_personas=$this->conexion->extraerRegistro();

        return $arreglo_personas;
    }

    function agregarPersonas($nombre,$apellido,$documento,$direccion,$sexo,$telefono,$email)
    {
        $sql = "INSERT INTO personas (nombre,apellido,documento,direccion,sexo,telefono,email) VALUES ('$nombre','$apellido','$documento','$direccion','$sexo','$telefono','$email')";

        $filas_afectadas=$this->conexion->consulta($sql);

        return $filas_afectadas;
    }
}
?>