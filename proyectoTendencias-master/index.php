<?php
require_once "librerias/configuraciones.php";
require_once "librerias/conexion.php";

if(isset($_SESSION["autenticado"]) && $_SESSION["autenticado"]=="SI")
{
    if(isset($_POST["modulo"]) && isset($_POST["accion"]))
    {
        $modulo=$_POST["modulo"];
        $accion=$_POST["accion"];

        if($modulo=='accesos')
        {
            require_once "vistas/accesos_VI.php";
            require_once "controladores/accesos_CO.php";

            $accesos_VI=new accesos_VI();
            $accesos_CO=new accesos_CO();

            if($accion=='LISTAR')
            {
                $accesos_VI->listar();
            }
            else if($accion=='VISTA_AGREGAR_ACCESOS')
            {
                $accesos_VI->agregar();
            }
            else if($accion=='CONTROLADOR_AGREGAR_ACCESOS')
            {
                $accesos_CO->agregar();
            }
            else if($accion=='VISTA_ACTUALIZAR_ACCESOS')
            {
                $accesos_VI->actualizar();
            }
            else if($accion=='CONTROLADOR_ACTUALIZAR_ACCESOS')
            {
                $accesos_CO->actualizar();
            }
        }
        elseif($modulo=='personas')
        {
            require_once "vistas/personas_VI.php";
            require_once "controladores/personas_CO.php";

            $personas_VI=new personas_VI();
            $personas_CO=new personas_CO();

            if($accion=='LISTAR')
            {
                $personas_VI->listarPersonas();
            }
            else if($accion=='VISTA_AGREGAR_PERSONAS')
            {
                $personas_VI->agregarPersonas();
            }
            else if($accion=='CONTROLADOR_AGREGAR_PERSONAS')
            {
                $personas_CO->agregarPersonas();
            }
        }
    }
    else
    {
        require_once "vistas/menu_VI.php";
        $menu_VI=new menu_VI();
        $menu_VI->verMenu();
    }
}
else if(isset($_POST["usuario"]) && isset($_POST["clave"]))
{
    require_once "controladores/accesos_CO.php";
    $accesos_CO=new accesos_CO();
    $accesos_CO->verificarInicioSesion();
}
else
{
    require_once "vistas/accesos_VI.php";
    $accesos_VI = new accesos_VI();
    $accesos_VI->formularioInicioSesion();
}
?>