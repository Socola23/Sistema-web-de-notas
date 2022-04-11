<?php
include("global/conexion.php");
if(isset($_SESSION['tipo_usuario'])){
    header("location: escritorio.php");
    exit();
}

if(isset($_POST["acceso"])){
    if(!empty($_POST["acceso"])){
        $datos = $_POST["acceso"];
        $estado = true;
        switch($datos[0]){
            case 1:
                $verifico = $conexion->prepare("SELECT `id_docente`, CONCAT(apellidos,' ',nombres) AS nombres FROM `docente` WHERE id_docente=? AND clave=? AND id_estado='0' LIMIT 1");
            break;
            case 2:
                $verifico = $conexion->prepare("SELECT `id_gestor`, CONCAT(apellidos,' ',nombres) AS nombres FROM `gestor` WHERE id_gestor=? AND clave=? AND id_estado='0' LIMIT 1");
            break;
            case 3:
                $verifico = $conexion->prepare("SELECT `id_alumno`, CONCAT(`apellidos`,`nombres`) AS nombres FROM `alumno` WHERE dni=? AND clave=? AND id_estado='0' LIMIT 1");
            break;
            default:
                $estado = false;
        }
        if($estado==true){
            $verifico->bind_param("ss",$datos[1],$datos[2]);
            $verifico->execute();
            $resultado = $verifico->get_result();
            if($resultado->num_rows==1){
                $sesion = $resultado->fetch_row();
                $_SESSION['tipo_usuario'] = $datos[0];
                $_SESSION["id_usuario"] = $sesion[0];
                $_SESSION['nombres'] = $sesion[1];
                header("location: escritorio.php");
                exit();
            } else {
                $_SESSION["tipo_mensaje"] = 0;
                $_SESSION["mensaje"] = "Datos incorrectos.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gestión Notas</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/toastr.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenido Nuevamente!</h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <select class="form-control" name="acceso[]" required>
                                                <option value="">Seleccione tipo de Usuario</option>
                                                <option value="3">Estudiante</option>
                                                <option value="1">Docente</option>
                                                <option value="2">Gestor</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control form-control-user" name="acceso[]" placeholder="Código" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="acceso[]" placeholder="Clave" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Acceder
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <script>
    $(function () {
        <?php 
            if(isset($_SESSION["mensaje"]) && isset($_SESSION["tipo_mensaje"])) {
                switch($_SESSION["tipo_mensaje"]){
                    case 1:
                        echo "toastr.success('".$_SESSION["mensaje"]."');";
                    break;
                    case 0:
                        echo "toastr.error('".$_SESSION["mensaje"]."');";
                    break;
                }
                
                unset($_SESSION["mensaje"],$_SESSION["tipo_mensaje"]); 
            } 
        ?>
    });
    </script>
</body>

</html>