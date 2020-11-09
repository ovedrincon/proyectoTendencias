<?php
require_once "modelos/accesos_MO.php";

class accesos_CO
{
    function __construct(){}

    function verificarInicioSesion()
    {
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];

        $conexion=new conexion('A');

        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->verificarInicioSesion($usuario,$clave);

        if($arreglo_accesos)
        {
            $_SESSION["autenticado"]="SI";
            header("Location: index.php");
        }
        else
        {
            header("Location: index.php?error=ERROR: Usuario No Registrado&usuario=$usuario");
        }
    }

    function agregar()
    {
        $usuario=$_POST["usuario"];
        $clave=$_POST["clave"];

        $conexion=new conexion('A');

        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->seleccionar('usuario',$usuario);

        if($arreglo_accesos)
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: El usuario <b>$usuario</b> ya existe"
            ];
        }
        else
        {
            $filas_afectadas=$accesos_MO->agregar($usuario,$clave);
            
            if($filas_afectadas)
            {
                $arreglo_accesos=$accesos_MO->seleccionar('usuario',$usuario);

                $usuario=$arreglo_accesos[0]->usuario;
                $fecha_creacion=$arreglo_accesos[0]->fecha_creacion;
                $fecha_actualizacion=$arreglo_accesos[0]->fecha_actualizacion;
                
                $respuesta = [
                    "estado" => "EXITO",
                    'mensaje' => "EXITO: Registro Guardado",
                    'usuario' => $usuario,
                    'fecha_creacion' => $fecha_creacion,
                    'fecha_actualizacion' => $fecha_actualizacion
                ];
            }
            else
            {
                $respuesta = [
                    "estado" => "ADVERTENCIA",
                    'mensaje' => "ADVERTENCIA: No se completo la consulta"
                ];
            }
        }

        echo json_encode($respuesta);
    }

    function actualizar()
    {
        $id_accesos=$_POST["id_accesos"];
        $clave=$_POST["clave"];

        $conexion=new conexion('A');

        $accesos_MO=new accesos_MO($conexion);

        $filas_afectadas=$accesos_MO->actualizar($id_accesos,$clave);
        
        if($filas_afectadas)
        {
            $arreglo_accesos=$accesos_MO->seleccionar("id_accesos",$id_accesos);
            $fecha_actualizacion=$arreglo_accesos[0]->fecha_actualizacion;

            $respuesta = [
                "estado" => "EXITO",
                'mensaje' => "EXITO: Registro Guardado",
                'id_accesos' => $id_accesos,
                'fecha_actualizacion' => $fecha_actualizacion
            ];
        }
        else
        {
            $respuesta = [
                "estado" => "ADVERTENCIA",
                'mensaje' => "ADVERTENCIA: No ocurrieron cambios"
            ];
        }
        
        echo json_encode($respuesta);
    }
}
?>