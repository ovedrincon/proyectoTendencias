<?php
class personas_VI
{
    function __construct()
    {
    }

    function listarPersonas()
    {
        require_once "modelos/personas_MO.php";

        $conexion = new conexion('A');
        $personas_MO = new personas_MO($conexion);

        $arreglo_personas = $personas_MO->listarPersonas();
    ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de personas en el programa</h3>
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#ventana_modal" onclick="vistaAgregarPersonas()"><i class="far fa-plus-square"></i> Agregar</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="listar_personas" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento</th>
                            <th>Direccion</th>
                            <th>Sexo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Fecha Creaci&oacute;n</th>
                            <th>Fecha Actualizaci&oacute;n</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($arreglo_personas) {
                            foreach ($arreglo_personas as $objeto_personas) {
                                $id_personas = $objeto_personas->id_personas;
                                $nombre = $objeto_personas->nombre;
                                $apellido = $objeto_personas->apellido;
                                $documento = $objeto_personas->documento;
                                $direccion = $objeto_personas->direccion;
                                $sexo = $objeto_personas->sexo;
                                $telefono = $objeto_personas->telefono;
                                $email = $objeto_personas->email;
                                $fecha_creacion = $objeto_personas->fecha_creacion;
                                $fecha_actualizacion = $objeto_personas->fecha_actualizacion;
                        ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td><?php echo $apellido; ?></td>
                                    <td><?php echo $documento; ?></td>
                                    <td><?php echo $direccion; ?></td>
                                    <td><?php echo $sexo; ?></td>
                                    <td><?php echo $telefono; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $fecha_creacion; ?></td>
                                    <td><?php echo $fecha_actualizacion; ?></td>
                                    <td>X</td>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Documento</th>
                            <th>Direccion</th>
                            <th>Sexo</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Fecha Creaci&oacute;n</th>
                            <th>Fecha Actualizaci&oacute;n</th>
                            <th>Acci&oacute;n</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
            function vistaAgregarPersonas() {
                $.post('index.php', {
                    modulo: 'personas',
                    accion: 'VISTA_AGREGAR_PERSONAS'
                }, function(respuesta) {
                    $('#titulo_modal').html('Agregar Personas');
                    $('#contenido_modal').html(respuesta);
                });
            }

            data_table_personas = organizarTabla({
                id: "listar_personas"
            });
        </script>

    <?php
    }


    function agregarPersonas()
    {
    ?>
        <div class="card">
            <div class="card-body">
                <form id="formulario_agregar_personas">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="documento">Documento:</label>
                                <input type="text" class="form-control" id="documento" name="documento">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sexo">Sexo;</label>
                                <select id="sexo" name="sexo" class="form-control">
                                    <option selected>Seleccione</option>
                                    <option>M</option>
                                    <option>F</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                    </div>


                    <input type="hidden" id="modulo" name="modulo" value="personas">
                    <input type="hidden" id="accion" name="accion" value="CONTROLADOR_AGREGAR_PERSONAS">
                    <button type="button" class="btn btn-primary float-right" onclick="controladorAgregarPersonas()"><i class="fas fa-save"></i> Guardar</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <script>
            function controladorAgregarPersonas() {
                var cadena = $('#formulario_agregar_personas').serialize();

                $.post('index.php', cadena, function(respuesta) {
                    var objeto_respuesta = JSON.parse(respuesta);

                    if (objeto_respuesta.estado == "EXITO") {
                        $('#formulario_agregar_personas')[0].reset();

                        exito(objeto_respuesta.mensaje);

                        data_table_personas.row.add([objeto_respuesta.nombre, objeto_respuesta.apellido, objeto_respuesta.documento, objeto_respuesta.direccion, objeto_respuesta.sexo, objeto_respuesta.telefono, objeto_respuesta.email, objeto_respuesta.fecha_creacion, objeto_respuesta.fecha_actualizacion, 'x']).draw();
                        /*
                        $.post('index.php',{modulo:'accesos',accion:'LISTAR'},function(respuesta)
                        {
                            $('#contenido').html(respuesta);
                        });
                        */
                    } else if (objeto_respuesta.estado == "ERROR") {
                        error(objeto_respuesta.mensaje);
                    } else {
                        advertencia();
                    }
                });
            }
        </script>
<?php
    }
}
?>