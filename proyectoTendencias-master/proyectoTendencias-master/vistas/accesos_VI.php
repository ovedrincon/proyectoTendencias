<?php
class accesos_VI
{
    function __construct(){}

    function formularioInicioSesion()
    {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>Empresa</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Font Awesome -->
            <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
            <!-- Ionicons -->
            <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
            <!-- icheck bootstrap -->
            <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
            <!-- Theme style -->
            <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
            <!-- Google Font: Source Sans Pro -->
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        </head>

        <body class="hold-transition login-page">
            <div class="login-box">
                <div class="login-logo">
                    <a href="#"><b>Empresa de</b>Software</a>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Iniciar Sesion</p>

                        <?php
                        if (isset($_GET["error"])) {
                            $error = $_GET["error"];
                            $usuario = $_GET["usuario"];

                            echo "<span style='color:red;'>" . $error . "</span><br><br>";
                        }
                        ?>

                        <form method="post">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="usuario" value="<?php if (isset($usuario)) {
                                                                                                    echo $usuario;
                                                                                                } ?>" placeholder="Digite su Usuario...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="clave" placeholder="Digite su Contraseña...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesion</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                        <p class="mb-1">
                            <a href="#">Olvido su contraseña</a>
                        </p>
                        <p class="mb-0">
                            <a href="#" class="text-center">Registrarse</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            <!-- /.login-box -->

            <!-- jQuery -->
            <script src="../../plugins/jquery/jquery.min.js"></script>
            <!-- Bootstrap 4 -->
            <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            <!-- AdminLTE App -->
            <script src="../../dist/js/adminlte.min.js"></script>

        </body>

        </html>
<?php
    }

    function listar()
    {
        require_once "modelos/accesos_MO.php";

        $conexion=new conexion('A');
        $accesos_MO=new accesos_MO($conexion);

        $arreglo_accesos=$accesos_MO->seleccionar();
        ?>
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Personas con Acceso al Sistema</h3>
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#ventana_modal" onclick="vistaAgregarAccesos()"><i class="far fa-plus-square"></i> Agregar</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="listar_accesos" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>Usuario</th>
                <th>Fecha Creaci&oacute;n</th>
                <th>Fecha Actualizaci&oacute;n</th>
                <th style="text-align:center;">Acci&oacute;n</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if($arreglo_accesos)
                {
                    foreach($arreglo_accesos as $objeto_accesos)
                    {
                        $id_accesos=$objeto_accesos->id_accesos;
                        $usuario=$objeto_accesos->usuario;
                        $fecha_creacion=$objeto_accesos->fecha_creacion;
                        $fecha_actualizacion=$objeto_accesos->fecha_actualizacion;
                        ?>
                        <tr>
                            <td><?php echo $usuario;?></td>
                            <td><?php echo $fecha_creacion;?></td>
                            <td><?php echo $fecha_actualizacion;?></td>
                            <td style="text-align:center;">
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ventana_modal" onclick="vistaActualizarAccesos('<?php echo $id_accesos;?>')" title="Actualizar"><i class="far fa-edit"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

                </tbody>
                <tfoot>
                <tr>
                <th>Usuario</th>
                <th>Fecha Creaci&oacute;n</th>
                <th>Fecha Actualizaci&oacute;n</th>
                <th style="text-align:center;">Acci&oacute;n</th>
                </tr>
                </tfoot>
            </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
        function vistaAgregarAccesos()
        {
            $.post('index.php',{modulo:'accesos',accion:'VISTA_AGREGAR_ACCESOS'},function(respuesta)
            {
                $('#titulo_modal').html('Agregar Accesos a Personas');
                $('#contenido_modal').html(respuesta);
            });
        }

        function vistaActualizarAccesos(id_accesos)
        {
            $.post('index.php',{modulo:'accesos',accion:'VISTA_ACTUALIZAR_ACCESOS',id_accesos:id_accesos},function(respuesta)
            {
                $('#titulo_modal').html('Actualizar Accesos a Personas');
                $('#contenido_modal').html(respuesta);
            });
        }

        data_table_accesos=organizarTabla({id:"listar_accesos"});
        </script>
<?php
    }

    function agregar()
    {
?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_agregar_accesos">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <input type="usuario" class="form-control" id="usuario" name="usuario">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave">
                </div>
              </div>
            </div>

            <input type="hidden" id="modulo" name="modulo" value="accesos">
            <input type="hidden" id="accion" name="accion" value="CONTROLADOR_AGREGAR_ACCESOS">
            <button type="button" class="btn btn-primary float-right" onclick="controladorAgregarAccesos()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
        function controladorAgregarAccesos()
        {
            var cadena=$('#formulario_agregar_accesos').serialize();

            $.post('index.php',cadena,function(respuesta)
            {
                var objeto_respuesta=JSON.parse(respuesta);

                if(objeto_respuesta.estado=="EXITO")
                {
                    $('#formulario_agregar_accesos')[0].reset();
                    
                    exito(objeto_respuesta.mensaje);

                    data_table_accesos.row.add([objeto_respuesta.usuario,objeto_respuesta.fecha_creacion,objeto_respuesta.fecha_actualizacion,'x']).draw();

                }
                else if(objeto_respuesta.estado=="ADVERTENCIA")
                {
                    advertencia(objeto_respuesta.mensaje);
                }
                else if(objeto_respuesta.estado=="ERROR")
                {
                    error(objeto_respuesta.mensaje);
                }
            });
        }
        </script>
<?php
    }

    function actualizar()
    {
      require_once "modelos/accesos_MO.php";

      $conexion=new conexion('A');
      $accesos_MO=new accesos_MO($conexion);

      $id_accesos=$_POST["id_accesos"];

      $arreglo_accesos=$accesos_MO->seleccionar("id_accesos",$id_accesos);
      $usuario=$arreglo_accesos[0]->usuario;
?>
        <div class="card">
          <div class="card-body">
            <form id="formulario_actualizar_accesos">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="usuario">Usuario</label>
                  <input type="text" class="form-control" value="<?php echo $usuario;?>" readonly="readonly">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave">
                </div>
              </div>
            </div>

            <input type="hidden" id="id_accesos" name="id_accesos" value="<?php echo $id_accesos;?>">
            <input type="hidden" id="modulo" name="modulo" value="accesos">
            <input type="hidden" id="accion" name="accion" value="CONTROLADOR_ACTUALIZAR_ACCESOS">
            <button type="button" class="btn btn-primary float-right" onclick="controladorActualizarAccesos()"><i class="fas fa-save"></i> Guardar</button>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <script>
        function controladorActualizarAccesos()
        {
            var cadena=$('#formulario_actualizar_accesos').serialize();

            $.post('index.php',cadena,function(respuesta)
            {
              var objeto_respuesta=JSON.parse(respuesta);
                
              if(objeto_respuesta.estado=="EXITO")
              {
                exito(objeto_respuesta.mensaje);
                $('#formulario_actualizar_accesos')[0].reset();

                $.post('index.php',{modulo:'accesos',accion:'LISTAR'},function(res){
                  $('#contenido').html(res);
                });
              }
              else if(objeto_respuesta.estado=="ADVERTENCIA")
              {
                advertencia(objeto_respuesta.mensaje);
              }
              else if(objeto_respuesta.estado=="ERROR")
              {
                  error(objeto_respuesta.mensaje);
              }
            });
        }
        </script>
      <?php
    }
}
?>