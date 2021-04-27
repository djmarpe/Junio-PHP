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
        <title>Match!</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        require_once '../Clases/UsuarioPreferencias.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        $usuarioMatch = $_SESSION['usuarioElegido'];
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
                        <li class = "breadcrumb-item" aria-current = "page"><a href = "../controladores/controlador.php?verGenteCercana=verGenteCercana" class = "text-decoration-underline text-dark">Gente cercana</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $usuarioMatch->getNombreUsuario() . ' ' . $usuarioMatch->getApellidosUsuario() ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <input type="hidden" name="nombre" value="<?= $usuarioMatch->getNombreUsuario() ?>">
                <input type="hidden" name="apellido" value="<?= $usuarioMatch->getApellidosUsuario() ?>">
                <?php
                if (isset($_SESSION['mensaje'])) {
                    ?>
                    <small class="my-5 d-block text-center bg-success mx-5 text-white"><?= $_SESSION['mensaje'] ?></small>
                    <?php
                }
                ?>

                <h3 class="my-5 text-decoration-underline text-center"><?= $usuarioMatch->getNombreUsuario() . ' ' . $usuarioMatch->getApellidosUsuario() ?></h3>
                <div class="row m-0">
                    <div class="col-12 col-sm-6">
                        <p><?= $usuarioMatch->getDescripcion() ?></p>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="row m-0">
                            <div class="col-12 col-sm-6 my-3">
                                <strong>País:</strong>
                                <input type="hidden" id="pais" value="<?= $usuarioMatch->getPais() ?>">
                                <small><?= $usuarioMatch->getPais() ?></small>
                            </div>
                            <div class="col-12 col-sm-6 my-3">
                                <strong>Localidad:</strong>
                                <input type="hidden" id="localidad" value="<?= $usuarioMatch->getLocalidad() ?>">
                                <small><?= $usuarioMatch->getLocalidad() ?></small>
                            </div>
                            <div class="col-12 col-sm-6 my-3">
                                <strong>Fecha de nacimiento:</strong>
                                <input type="hidden" id="fechaNac" value="<?= $usuarioMatch->getFechaNacimientoUsuario() ?>">
                                <small><?= $usuarioMatch->getFechaNacimientoUsuario() ?></small>
                            </div>
                            <div class="col-12 col-sm-6 my-3">
                                <strong>Correo electrónico:</strong>
                                <input type="hidden" id="emailMatch" value="<?= $usuarioMatch->getEmail() ?>">
                                <input type="hidden" id="emailUsuario" value="<?= $usuarioLogin->getEmail() ?>">
                                <small><?= $usuarioMatch->getEmail() ?></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-0">
                    <form action="../controladores/controlador.php" method="POST" class="col-12 my-3 text-center">
                        <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $usuarioMatch->getIdUsuario() ?>">
                        <?php
                        if (isset($_SESSION['mensaje'])) {
                            if ($_SESSION['mensaje'] == 'Nuevo amigo') {
                                ?>
                                <input type="submit" name="conectarAmigo" value="Conectar" class="btn btn-primary" disabled>
                                <?php
                            } else {
                                ?>
                                <input type="submit" name="conectarAmigo" value="Conectar" class="btn btn-primary">
                                <?php
                            }
                        }
                        ?>

                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                            Enviar mensaje
                        </button>
                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Enviar un mensaje</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="../controladores/controlador.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-2">
                                                <small class="d-block float-start">De:</small>
                                                <input type="hidden" name="idUsuarioEmisor" value="<?= $usuarioLogin->getId() ?>">
                                                <input type="email" name="email_from" class="form-control" id="emailUsuarioEmisor" readonly>
                                            </div>

                                            <div class="my-2">
                                                <small class="d-block float-start">Para:</small>
                                                <input type="hidden" name="idUsuarioEmisor" value="<?= $usuarioMatch->getIdUsuario() ?>">
                                                <input type="email" name="email_to" class="form-control" id="emailUsuarioReceptor" readonly>
                                            </div>

                                            <div class="my-2">
                                                <small class="d-block float-start">Asunto:</small>
                                                <input type="text" name="subject" class="form-control">
                                            </div>

                                            <div class="my-2">
                                                <small class="d-block float-start">Mensaje:</small>
                                                <textarea type="text" rows="5" name="body" class="form-control"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-primary my-2" value="Enviar" name="enviarMensaje">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            var emailMatch = document.getElementById('emailMatch').value
                            var emailLogin = document.getElementById('emailUsuario').value
                            document.getElementById('emailUsuarioEmisor').value = emailLogin;
                            document.getElementById('emailUsuarioReceptor').value = emailMatch;
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/all.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
