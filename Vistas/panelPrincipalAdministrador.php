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
        <title>Dashboard</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        $listaUsuariosTotal = [];
        $listaAmigos = [];
        $listaMensajes = [];
        $usuariosOnline = 0;
        if (isset($_SESSION['listaAmigos'])) {
            $listaAmigos = $_SESSION['listaAmigos'];
        }
        if (isset($_SESSION['usuariosOnline'])) {
            $usuariosOnline = $_SESSION['usuariosOnline'];
        }
        if (isset($_SESSION['listaMensajes'])) {
            $listaMensajes = $_SESSION['listaMensajes'];
        }
        if (isset($_SESSION['listaUsuariosTotal'])) {
            $listaUsuariosTotal = $_SESSION['listaUsuariosTotal'];
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
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <div class="row m-0 justify-content-between">
                    <div class="col-12 col-md-5 m-2 p-2 rounded" style="border: 3px solid #014957;">
                        <p>Mi perfil</p>
                    </div>
                    <div class="col-12 col-md-5 m-2 p-2 rounded" style="border: 3px solid #014957;">
                        <h5 class="m-0 py-1">Mis amigos</h5>
                        <small class="d-block">Hay un total de <span class="text-success"><?= $usuariosOnline ?></span> usuarios conectados en la red.</small>
                        <?php
                        if (sizeof($listaAmigos) == 0) {
                            ?>
                            <small>Es una lastima que no tengas amigos agregados, ve ahora a <b>Buscar gente</b></small>
                            <?php
                        } else {
                            ?>
                            <small class="d-block">Amigos agregados: <span class="text-success"><?= sizeof($listaAmigos) ?></span></small>
                            <a href="../controladores/controlador.php?verAmigos=verAmigos" class="btn btn-outline-primary mt-4">Ver mis amigos</a>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-12 col-md-5 m-2 p-2 rounded" style="border: 3px solid #014957;">
                        <h5 class="m-0 py-1">Conozca a gente nueva</h5>
                        <small class="d-block">Con un simple click, podrá ver un listado de gente según el nivel de afinidad más similar al suyo.</small>
                        <a href="../controladores/controlador.php?verGenteCercana=verGenteCercana" class="btn btn-outline-primary mt-4">Buscar gente</a>
                    </div>
                    <div class="col-12 col-md-5 m-2 p-2 rounded" style="border: 3px solid #014957;">
                        <h5 class="m-0 py-1">Bandeja de entrada</h5>
                        <?php
                        if (sizeof($listaMensajes) == 0) {
                            ?>
                        <small class="d-block">No tienes mensajes nuevos</small>
                            <?php
                        } else {
                            ?>
                            <small class="d-block">Tienes <span class="text-success"><?= sizeof($listaMensajes) ?></span> mensajes pendientes sin leer</small>
                            <?php
                        }
                        ?>
                        <a href="../controladores/controlador.php?verMisMensajes=verMisMensajes" class="btn btn-outline-primary mt-4">Ver mensajes</a>
                    </div>
                    <div class="col-12 col-md-5 m-2 p-2 rounded" style="border: 3px solid #014957;">
                        <h5 class="m-0 py-1">Administrador de usuarios</h5>
                        <?php
                        if (sizeof($listaUsuariosTotal) == 0) {
                            ?>
                            <small class="d-block">No hay usuarios registrados en la red.</small>
                            <?php
                        } else {
                            ?>
                            <small class="d-block">Hay <span class="text-success"><?= sizeof($listaUsuariosTotal) + 1 ?></span> usuarios registrados</small>
                            <?php
                        }
                        ?>
                        <a href="../controladores/controlador.php?administrarUsuarios=administrarUsuarios" class="btn btn-outline-primary mt-4">Administrar usuarios</a>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
