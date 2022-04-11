<?php 
include("global/conexion.php");
include("global/top.php");
if($_SESSION['tipo_usuario']!=2){
    header("location: escritorio.php");
}
if(isset($_GET["eliminar"])){
    $conexion->query("DELETE FROM `aula` WHERE id_aula='".$_GET["eliminar"]."'");
    header("location: aula.php");
    exit();
}
?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Gestión Aula</h1>
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Lista Aulas</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                    aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Opciones:</div>
                                    <a class="dropdown-item" href="?nuevo">Nuevo</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if(!isset($_GET["nuevo"])&&!isset($_GET["editar"])) { ?>
                            <table class="table">
                                <tr>
                                    <td>Aula</td>
                                    <td>Opciones</td>
                                </tr>
                                <?php
                                    $muestro_docentes = $conexion->query("SELECT id_aula,CONCAT( grado,'° ',seccion,' ',
																			(
																			    CASE nivel
																			    WHEN 0 THEN
																			    'Inicial'
																			    WHEN 1 THEN
																			    'Primaria'
																			    WHEN 2 THEN
																			    'Secundaria'
																			    END
																			)
																			) AS aula FROM `aula`");
                                    while($fila = $muestro_docentes->fetch_row()){
                                        echo "<tr>";
                                        echo "<td>$fila[1]</td>";
                                        echo '
                                        <td>
                                        <div class="dropdown mb-4">
                                            <button class="btn btn-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Opciones
                                            </button>
                                            <div class="dropdown-menu animated--fade-in"
                                                aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="?editar='.$fila[0].'">Editar</a>
                                                <a class="dropdown-item" href="?eliminar='.$fila[0].'">Eliminar</a>
                                            </div>
                                        </div>
                                        </td>';
                                        echo "</tr>";
                                    }
                                ?>
                                <tr>

                                </tr>
                            </table>
                            <?php } elseif(!isset($_GET["nuevo"])&&isset($_GET["editar"])) {
                                if(isset($_POST["editar"])){
                                    if(!empty($_POST["editar"])){
                                        $datos = $_POST["editar"];
                                        $verificoExistencia = $conexion->query("SELECT `id_aula` FROM `aula` WHERE 
                                            `nivel` = '$datos[0]' AND `grado` = '$datos[1]' AND `seccion` = '$datos[2]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("UPDATE `aula` SET `nivel`='$datos[0]',`grado`='$datos[1]',`seccion`='$datos[2]' WHERE `id_aula`='".$_GET["editar"]."'");
                                        }
                                        header("location: aula.php");
                                        exit();
                                    }
                                }
                                $muestro_datos = $conexion->query("SELECT `id_aula`, `nivel`, `grado`, `seccion` FROM `aula` WHERE id_aula='".$_GET["editar"]."'");
                                $datos = $muestro_datos->fetch_row();

                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Nivel:</label>
                                                <select name="editar[]" class="form-control">
                                                    <option value="">Selecciona un nivel</option>
                                                    <option value="0"<?php echo($datos[1]=='0')?" selected":""?>>Inicial</option>
                                                    <option value="1"<?php echo($datos[1]=='1')?" selected":""?>>Primaria</option>
                                                    <option value="2"<?php echo($datos[1]=='2')?" selected":""?>>Secundaria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Grado:</label>
                                                <select name="editar[]" class="form-control">
                                                    <option value="">Selecciona un grado</option>
                                                    <option value="1"<?php echo($datos[2]=='1')?" selected":""?>>1°</option>
                                                    <option value="2"<?php echo($datos[2]=='2')?" selected":""?>>2°</option>
                                                    <option value="3"<?php echo($datos[2]=='3')?" selected":""?>>3°</option>
                                                    <option value="4"<?php echo($datos[2]=='4')?" selected":""?>>4°</option>
                                                    <option value="5"<?php echo($datos[2]=='5')?" selected":""?>>5°</option>
                                                    <option value="6"<?php echo($datos[2]=='6')?" selected":""?>>6°</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Sección:</label>
                                                <select class="form-control" required name="editar[]">
                                                    <option value="">Seleccione una sección</option>
                                                    <option value="A"<?php echo($datos[3]=='A')?" selected":""?>>A</option>
                                                    <option value="B"<?php echo($datos[3]=='B')?" selected":""?>>B</option>
                                                    <option value="C"<?php echo($datos[3]=='C')?" selected":""?>>C</option>
                                                    <option value="D"<?php echo($datos[3]=='D')?" selected":""?>>D</option>
                                                    <option value="E"<?php echo($datos[3]=='E')?" selected":""?>>E</option>
                                                    <option value="F"<?php echo($datos[3]=='F')?" selected":""?>>F</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Modificar</button>
                                </form>
                            <?php } elseif(isset($_GET["nuevo"])&&!isset($_GET["editar"])) {
                                if(isset($_POST["crear"])){
                                    if(!empty($_POST["crear"])){
                                        $datos = $_POST["crear"];
                                        $verificoExistencia = $conexion->query("SELECT `id_aula` FROM `aula` WHERE 
                                            `nivel` = '$datos[0]' AND `grado` = '$datos[1]' AND `seccion` = '$datos[2]'");
                                        if($verificoExistencia->num_rows==0){
                                            $conexion->query("INSERT INTO `aula`(`nivel`, `grado`, `seccion`) VALUES ('$datos[0]','$datos[1]','$datos[2]')");
                                        }
                                        header("location: aula.php");
                                        exit();
                                    }
                                }
                            ?>
                                <form method="POST">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Nivel:</label>
                                                <select name="crear[]" class="form-control">
                                                    <option value="">Selecciona un nivel</option>
                                                    <option value="0">Inicial</option>
                                                    <option value="1">Primaria</option>
                                                    <option value="2">Secundaria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Grado:</label>
                                                <select name="crear[]" class="form-control">
                                                    <option value="">Selecciona un grado</option>
                                                    <option value="1">1°</option>
                                                    <option value="2">2°</option>
                                                    <option value="3">3°</option>
                                                    <option value="4">4°</option>
                                                    <option value="5">5°</option>
                                                    <option value="6">6°</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="form-group">
                                                <label>Sección:</label>
                                                <select class="form-control" required name="crear[]">
                                                    <option value="">Seleccione una sección</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Crear</button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End of Main Content -->
<?php include("global/bottom.php"); ?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>