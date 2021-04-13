<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/miCss.css">
        <title>Registro</title>
    </head>
    <body class="background-dark-blue">

        <div class="row m-3 d-flex justify-content-center">
            <div class=" col-12 col-md-8 bg-white">
                <form action="../controladores/controlador.php" method="POST">
                    <?php
                    session_start();
                    if (isset($_SESSION['mensaje'])) {
                        ?>
                        <small class="d-block text-center bg-warning my-2 py-2"><?= $_SESSION['mensaje'] ?></small>
                        <?php
                    }
                    ?>
                    <h2 class="my-2 text-center">Registro</h2>
                    <div class="my-2">
                        <small>Nombre</small>
                        <input class="form-control" type="text" name="register_name" placeholder="Ej: Juan" required>
                    </div>
                    <div class="my-2">
                        <small>Apellidos</small>
                        <input class="form-control" type="text" name="register_surname" placeholder="Ej: Fernández" required>
                    </div>
                    <div class="my-2">
                        <small>Email</small>
                        <input class="form-control" type="email" name="register_email" placeholder="Ej: juan_fernandez@gmail.com" required>
                    </div>
                    <div class="my-2">
                        <small>Contraseña</small>
                        <input class="form-control" type="password" name="register_passwd" required>
                    </div>
                    <div class="my-2">
                        <small>Fecha de nacimiento</small>
                        <input class="form-control" type="date" name="register_fecNac" required>
                    </div>
                    <div class="my-2">
                        <small>Pais</small>
                        <input class="form-control" type="text" name="register_country" required>
                    </div>
                    <div class="my-2">
                        <small>Localidad</small>
                        <input class="form-control" type="text" name="register_city" required>
                    </div>
                    <div class="my-2">
                        <small>Sexo</small>
                        <select class="form-control" name="register_sex" required>
                            <option selected>Hombre</option>
                            <option>Mujer</option>
                        </select>
                    </div>
                    <div class="my-2">
                        <small>Descripcion</small>
                        <textarea class="form-control" type="text" name="register_description" rows="5" placeholder="Soy una persona ..." required></textarea>
                    </div>
                    <div class="my-2 text-center">
                        <a href="../index.php" class="btn btn-outline-primary w-25 mx-2">Página principal</a>
                        <input type="submit" class="btn btn-primary w-25 mx-2" name="btn_register" value="Registrar">
                    </div>
                </form>
            </div>
        </div>

        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
