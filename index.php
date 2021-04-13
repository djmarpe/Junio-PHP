<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/all.min.css">
        <link rel="stylesheet" type="text/css" href="css/miCss.css">
        <title>Home</title>
    </head>
    <body class="background-dark-blue">
        <?php
        if (isset($_SESSION['mensaje'])) {
            unset($_SESSION['mensaje']);
        }
        ?>
        <div class="row m-3">
            <div class="col-12 bg-white">
                <h2 class="my-2 text-center">Bienvenido a <i>Matches</i></h2>
                <p class="my-2">En nuestra web podrás conocer a gente que tenga gustos similares a los tuyos.</p>
                <p class="my-2">Además, podrás covensar con ellos con un sistema de mensajeria que podrás encontrar una vez registrado en nuestro sistema.</p>
                <a class="float-end btn btn-outline-primary m-2" href="controladores/controlador.php?goToLogin=goToLogin">Iniciar sesión</a>
                <a class="float-end btn btn-primary m-2" href="controladores/controlador.php?goToRegister=goToRegister">Registrarse</a>
            </div>
        </div>

        <script src="js/all.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>