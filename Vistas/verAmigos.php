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
        <title>Mis amigos</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        require_once '../Clases/UsuarioPreferencias.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        $misAmigos = [];

        if (isset($_SESSION['misAmigos'])) {
            $misAmigos = $_SESSION['misAmigos'];
        }
        ?>
        <div class="row m-3">
            <div class="col-12 bg-white align-self-center py-2">
                <div class="row m-0">
                    <div class="col-6 bg-white align-self-center">
                        <small class="text-muted float-start align-self-center">Conectado como: <?= $usuarioLogin->getName() . ' ' . $usuarioLogin->getSurname() ?></small>
                    </div>
                    <div class="col-6 bg-white">
                        <a href="../controladores/controlador.php?cerrarSesion=cerrarSesion" class="btn btn-primary float-end">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-2">
                        <?php
                        if ($usuarioLogin->getRol() == 'Administrador') {
                            ?>
                            <li class = "breadcrumb-item" aria-current = "page"><a href = "../controladores/controlador.php?dashboardAdmin=dashboardAdmin" class = "text-decoration-underline text-dark">Dashboard</a></li>
                            <?php
                        } else if ($usuarioLogin->getRol() == 'Usuario') {
                            ?>
                            <li class = "breadcrumb-item" aria-current = "page"><a href = "../controladores/controlador.php?dashboardUsuario=dashboardUsuario" class = "text-decoration-underline text-dark">Dashboard</a></li>
                            <?php
                        }
                        ?>
                        <li class = "breadcrumb-item" aria-current = "page">Ver amigos</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <div class="row m-0 justify-content-between">
                    <?php
                    for ($i = 0; $i < sizeof($misAmigos); $i++) {
                        $usuarioAux = $misAmigos[$i];
                        ?>
                        <form action="../controladores/controlador.php" method="POST" class="col-12 col-md-5">
                            <div class="m-2 p-2 rounded" style="border: 3px solid #014957;">
                                <input type="hidden" value="<?= $usuarioAux->getId() ?>" name="idUsuario">
                                <h5 class="m-0 text-center"><?= $usuarioAux->getName() . ' ' . $usuarioAux->getSurname() ?></h5>
                                <small class="d-block my-3"><?= $usuarioAux->getDescription() ?></small>
                                <div class="row my-3">
                                    <div class="col-12 col-sm-6">
                                        <strong>País:</strong>
                                        <small><?= $usuarioAux->getCountry() ?></small>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <strong>Localidad:</strong>
                                        <small><?= $usuarioAux->getCity() ?></small>
                                    </div>
                                </div>
                                <div class="mt-3 text-center">
                                    <input class="btn btn-outline-primary" type="submit" name="verAmigo" value="Ver en detalle">
                                </div>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/all.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
