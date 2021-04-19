    <!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/all.min.css">
        <link rel="stylesheet" type="text/css" href="../css/miCss.css">
        <title>Iniciar sesión</title>
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
                    <h2 class="my-2 text-center">Iniciar sesión</h2>
                    <div class="my-2">
                        <small>Email</small>
                        <input class="form-control" type="email" name="login_email" placeholder="Ej: juan_fernandez@gmail.com" required>
                    </div>
                    <div class="my-2">
                        <small>Contraseña</small>
                        <input class="form-control" type="password" name="login_passwd" required>
                    </div>
                    <div class="my-2 text-center">
                        <a href="../index.php" class="btn btn-outline-primary w-25 mx-2">Página principal</a>
                        <input type="submit" class="btn btn-primary w-25 mx-2" name="btn_login" value="Iniciar sesión">
                    </div>
                </form>
            </div>
        </div>
        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
