<?php
require_once "modelos/personas_MO.php";

class personas_CO
{
    function __construct()
    {
    }

    function agregarPersonas()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $documento = $_POST['documento'];
        $direccion = $_POST['direccion'];
        $sexo = $_POST['sexo'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];

        $conexion = new conexion('A');

        $personas_MO = new personas_MO($conexion);

        $arreglo_personas = $personas_MO->seleccionarPorPersonas($documento);

        if ($arreglo_personas) {
            $respuesta = [
                "estado" => "ERROR",
                'mensaje' => "ERROR: El usuario <b>$nombre</b> ya existe"
            ];
        } else {
            $filas_afectadas = $personas_MO->agregarPersonas($nombre, $apellido, $documento, $direccion, $sexo, $telefono, $email);

            if ($filas_afectadas) {
                $arreglo_personas = $personas_MO->seleccionarPorPersonas($documento);

                $nombre = $arreglo_personas[0]->nombre;
                $apellido = $arreglo_personas[0]->apellido;
                $documento = $arreglo_personas[0]->documento;
                $direccion = $arreglo_personas[0]->direccion;
                $sexo = $arreglo_personas[0]->sexo;
                $telefono = $arreglo_personas[0]->telefono;
                $email = $arreglo_personas[0]->email;
                $fecha_creacion = $arreglo_personas[0]->fecha_creacion;
                $fecha_actualizacion = $arreglo_personas[0]->fecha_actualizacion;

                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Registro Guardado",
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'documento' => $documento,
                    'direccion' => $direccion,
                    'sexo' => $sexo,
                    'telefono' => $telefono,
                    'email' => $email,
                    'fecha_creacion' => $fecha_creacion,
                    'fecha_actualizacion' => $fecha_actualizacion
                ];
            } else {
                $respuesta = [
                    "estado" => "ERROR",
                    'mensaje' => "ERROR: No se completo la consulta"
                ];
            }
        }

        echo json_encode($respuesta);
    }
}
?>