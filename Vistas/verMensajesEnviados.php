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
        <title>Mensajes enviados</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        require_once '../Clases/Mensaje.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        if (isset($_SESSION['mensajesEnviados'])) {
            $listaMensajesEnviados = $_SESSION['mensajesEnviados'];
        }

        $listaAmigos = [];
        if (isset($_SESSION['listaAmigos'])) {
            $listaAmigos = $_SESSION['listaAmigos'];
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
                        switch ($usuarioLogin->getRol()) {
                            case 'Administrador':
                                ?>
                                <li class="breadcrumb-item" aria-current="page"><a class="text-dark text-decoration-underline" href="../controladores/controlador.php?dashboardAdmin=dashboardAdmin">Dashboard</a></li>
                                <?php
                                break;
                            case 'Usuario':
                                ?>
                                <li class = "breadcrumb-item" aria-current = "page"><a href = "../controladores/controlador.php?dashboardUsuario=dashboardUsuario" class = "text-decoration-underline text-dark">Dashboard</a></li>
                            <?php
                        }
                        ?>
                        <li class="breadcrumb-item active">Ver mensajes enviados</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <div class="row m-0 justify-content-between">
                    <div class="col-12 col-md-7 m-0 p-0">
                        <h5 class="my-2 text-center">Mensajes enviados</h5>
                        <table class="w-100 table">
                            <tr>
                                <th>De</th>
                                <th>Para</th>
                                <th>Asunto</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <?php
                            if (isset($listaMensajesEnviados)) {
                                if (sizeof($listaMensajesEnviados) > 0) {
                                    for ($i = 0; $i < sizeof($listaMensajesEnviados); $i++) {
                                        $mensajeAux = $listaMensajesEnviados[$i];
                                        ?>
                                        <tr>
                                        <input type="hidden" name="idUsuarioEmisor" id="idUsuarioEmisor" value="<?= $mensajeAux->getIdUsuarioEmisor() ?>">
                                        <td name="ver_emailEmisor" id="ver_usuarioEmisor<?= $i ?>"><?= $mensajeAux->getEmailUsuarioEmisor() ?></td>
                                        <input type="hidden" name="idUsuarioReceptor" id="idUsuarioReceptor" value="<?= $mensajeAux->getIdUsuarioReceptor() ?>">
                                        <td name="ver_emailReceptor" id="ver_usuarioReceptor<?= $i ?>"><?= $mensajeAux->getEmailUsuarioReceptor() ?></td>
                                        <input type="hidden" name="asunto" id="asunto" value="<?= $mensajeAux->getAsunto() ?>">
                                        <td name="ver_asunto" id="ver_asunto<?= $i ?>"><?= $mensajeAux->getAsunto() ?></td>
                                        <input type="hidden" name="ver_cuerpo" id="ver_cuerpo<?= $i ?>" value="<?= $mensajeAux->getCuerpo() ?>">
                                        <?php
                                        switch ($mensajeAux->getLeido()) {
                                            case 0:
                                                ?>
                                                <td><i class="fas fa-check-double text-secondary"></i></td>
                                                <?php
                                                break;
                                            case 1:
                                                ?>
                                                <td><i class="fas fa-check-double text-primary"></i></td>
                                                <?php
                                                break;
                                        }
                                        ?>

                                        <td><button class="btn m-0 p-0 ver" data-bs-toggle="modal" data-bs-target="#exampleModal1" onclick="ver(<?= $i ?>)"><i class="fas fa-eye text-primary"></i></button></td>

                                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Mensaje enviado</h5>
                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <small class="d-block float-start">De:</small>
                                                            <input type="hidden" name="idUsuarioEmisor" value="<?= $usuarioLogin->getId() ?>">
                                                            <input type="email" name="email_from" class="form-control" id="mensaje_Emisor" readonly>
                                                        </div>

                                                        <div class="my-2">
                                                            <small class="d-block float-start">Para:</small>
                                                            <input type="hidden" name="idUsuarioEmisor">
                                                            <input type="email" name="email_to" class="form-control" id="mensaje_Receptor" readonly>
                                                        </div>

                                                        <div class="my-2">
                                                            <small class="d-block float-start">Asunto:</small>
                                                            <input type="text" name="subject" class="form-control" id="mensaje_Subject" readonly>
                                                        </div>

                                                        <div class="my-2">
                                                            <small class="d-block float-start">Mensaje:</small>
                                                            <textarea type="text" rows="5" name="body" class="form-control" id="mensaje_Body" readonly></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </tr>

                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5"><small class="d-block text-center">No hay mensajes enviados</small></td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="col-12 col-md-4">
                        <form class="my-3 sticky-top" action="../controladores/controlador.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <small class="d-block float-start">De:</small>
                                <input type="hidden" name="idUsuarioEmisor" value="<?= $usuarioLogin->getId() ?>">
                                <input type="email" name="email_from" class="form-control" id="emailUsuarioEmisor" value="<?= $usuarioLogin->getEmail() ?>" readonly>
                            </div>

                            <div class="my-2">
                                <small class="d-block float-start">Para:</small>
                                <?php
                                if (sizeof($listaAmigos) > 0) {
                                    ?>
                                    <select name="email_to" class="form-control" id="emailUsuarioReceptor" >
                                        <?php
                                        for ($i = 0; $i < sizeof($listaAmigos); $i++) {
                                            $amigoAux = $listaAmigos[$i];
                                            ?>
                                            <option><?= $amigoAux->getEmail() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                } else {
                                    ?>
                                    <small class="d-block">No tienes amigos agregados</small>
                                    <?php
                                }
                                ?>

                            </div>

                            <div class="my-2">
                                <small class="d-block float-start">Asunto:</small>
                                <input type="text" name="subject" class="form-control" required>
                            </div>

                            <div class="my-2">
                                <small class="d-block float-start">Mensaje:</small>
                                <textarea type="text" rows="5" name="body" class="form-control" required></textarea>
                            </div>
                            <?php
                            if (sizeof($listaAmigos) > 0) {
                                ?>
                                <input type="submit" class="btn btn-primary my-2" value="Enviar" name="enviarMensaje">
                                <?php
                            } else {
                                ?>
                                <input type="submit" class="btn btn-primary my-2" value="Enviar" name="enviarMensaje" disabled>
                                <?php
                            }
                            ?>

                        </form>
                    </div>
                </div>

            </div>
        </div>

        <script>
            function ver(i) {
                let usuarioEmisor = document.getElementById('ver_usuarioEmisor' + i).innerText;
                document.getElementById('mensaje_Emisor').value = usuarioEmisor;

                console.log(usuarioEmisor);

                let usuarioReceptor = document.getElementById('ver_usuarioReceptor' + i).innerText;
                document.getElementById('mensaje_Receptor').value = usuarioReceptor;

                console.log(usuarioReceptor);

                let asunto = document.getElementById('ver_asunto' + i).innerText;
                document.getElementById('mensaje_Subject').value = asunto;

                let cuerpo = document.getElementById('ver_cuerpo' + i).value;
                document.getElementById('mensaje_Body').value = cuerpo;
            }
        </script>
        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
