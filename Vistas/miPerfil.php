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
        <script src="../js/miJS.js"></script>
        <title>Mi perfil</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        require_once '../Clases/UsuarioPreferencias.php';
        require_once '../Clases/Preferencia.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        $usuarioLoginPreferencias = $_SESSION['usuarioLoginPreferencias'];
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
                        <li class="breadcrumb-item active" aria-current="page">Mi perfil</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <input type="hidden" name="nombre" value="<?= $usuarioLoginPreferencias->getNombreUsuario() ?>">
                <input type="hidden" name="apellido" value="<?= $usuarioLoginPreferencias->getApellidosUsuario() ?>">
                <?php
                if (isset($_SESSION['mensaje'])) {
                    ?>
                    <small class="my-5 d-block text-center bg-success mx-5 text-white"><?= $_SESSION['mensaje'] ?></small>
                    <?php
                }
                ?>

                <h3 class="my-5 text-decoration-underline text-center">Mi perfil</h3>
                <div class="row m-0 justify-content-between">
                    <div class="col-12 col-sm-5">
                        <form action="../controladores/controlador.php" method="POST">
                            <input type="hidden" name="idUsuario" value="<?= $usuarioLogin->getId() ?>">
                            <h4 class="mb-4 text-center">Datos del usuario</h4>
                            <div class="row m-0 justify-content-between">
                                <div class="col-12 col-sm-6 mb-2">
                                    <strong>Nombre:</strong>
                                    <input class="form-control" type="text" name="usuario_nombre" value="<?= $usuarioLogin->getName() ?>">
                                </div>
                                <div class="col-12 col-sm-6 mb-2">
                                    <strong>Apellidos:</strong>
                                    <input class="form-control" type="text" name="usuario_apellidos" value="<?= $usuarioLogin->getSurname() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2">
                                    <strong>Email:</strong>
                                    <input class="form-control" type="text" name="usuario_email" value="<?= $usuarioLogin->getEmail() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2">
                                    <strong>Contraseña:</strong>
                                    <input class="form-control" type="password" name="usuario_passwd" placeholder="Nueva contraseña">
                                </div>
                                <div class="col-12 col-sm-6 my-2">
                                    <strong>Pais:</strong>
                                    <input class="form-control" type="text" name="usuario_pais" value="<?= $usuarioLogin->getCountry() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2">
                                    <strong>Localidad:</strong>
                                    <input class="form-control" type="text" name="usuario_localidad" value="<?= $usuarioLogin->getCity() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2">
                                    <strong>Descripción:</strong>
                                    <textarea class="form-control" rows="5" name="usuario_descripcion"><?= $usuarioLogin->getDescription() ?></textarea>
                                </div>
                                <input class="btn btn-outline-primary my-3" type="submit" name="actualizarPerfil" value="Actualizar perfil">
                            </div>
                        </form>
                    </div>

                    <div class="col-12 col-sm-5">
                        <form action="../controladores/controlador.php" method="POST">
                            <input type="hidden" name="idUsuarioPreferencias" value="<?= $usuarioLoginPreferencias->getIdUsuario() ?>">
                            <?php
                            $preferenciasUsuario = $usuarioLoginPreferencias->getPreferencias();
                            $preferencia1 = $preferenciasUsuario[0];
                            $preferencia2 = $preferenciasUsuario[1];
                            $preferencia3 = $preferenciasUsuario[2];
                            $preferencia4 = $preferenciasUsuario[3];
                            $preferencia5 = $preferenciasUsuario[4];
                            $preferencia6 = $preferenciasUsuario[5];
                            ?>
                            <h4 class="mb-4 text-center">Preferencias del usuario</h4>
                            <div class="row m-0 justify-content-between">
                                <div class="col-12 col-sm-6 mb-2 text-center">
                                    <strong class="d-block">-> ¿Relación seria? <-</strong>
                                    <?php
                                    if ($preferencia1->getValue() == "si") {
                                        ?>
                                        <input id="rel_si" type="radio" name="usuario_relacionSeria" value="si" checked>
                                        <label for="rel_si">Si</label>
                                        <input id="rel_no" type="radio" name="usuario_relacionSeria" value="no">
                                        <label for="rel_no">No</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input id="rel_si" type="radio" name="usuario_relacionSeria" value="si">
                                        <label for="rel_si">Si</label>
                                        <input id="rel_no" type="radio" name="usuario_relacionSeria" value="no" checked>
                                        <label for="rel_no">No</label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-12 col-sm-6 mb-2 text-center">
                                    <strong class="d-block">->Fanatismo por el deporte<-</strong>
                                    <input id="deporte_hidden" type="hidden" name="usuario_deporte" value="<?= $preferencia2->getValue() ?>">
                                    <small id="deporte_value" name="usuario_deporte"><?= $preferencia2->getValue() ?></small>
                                    <input id="range_deporte" type="range" min="0" max="10" step="1" oninput="rangeDeporte()" value="<?= $preferencia2->getValue() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2 text-center">
                                    <strong class="d-block">-> Fanatismo por el arte <-</strong>
                                    <input id="arte_hidden" type="hidden" name="usuario_arte" value="<?= $preferencia3->getValue() ?>">
                                    <small id="arte_value" name="usuario_arte"><?= $preferencia3->getValue() ?></small>
                                    <input id="range_arte" type="range" min="0" max="10" step="1" oninput="rangeArte()" value="<?= $preferencia3->getValue() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2 text-center">
                                    <strong class="d-block">-> Intereses políticos <-</strong>
                                    <input id="politica_hidden" type="hidden" name="usuario_politica" value="<?= $preferencia4->getValue() ?>">
                                    <small id="politica_value" name="usuario_politica"><?= $preferencia4->getValue() ?></small>
                                    <input id="range_politica" type="range" min="0" max="10" step="1" oninput="rangePolitica()" value="<?= $preferencia4->getValue() ?>">
                                </div>
                                <div class="col-12 col-sm-6 my-2 text-center">
                                    <strong class="d-block">-> ¿Quieres tener hijos? <-</strong>
                                    <?php
                                    if ($preferencia5->getValue() == "si") {
                                        ?>
                                        <input id="hijos_si" type="radio" name="usuario_hijos" value="si" checked>
                                        <label for="hijos_si">Si</label>
                                        <input id="hijos_no" type="radio" name="usuario_hijos" value="no">
                                        <label for="hijos_no">No</label>
                                        <?php
                                    } else {
                                        ?>
                                        <input id="hijos_si" type="radio" name="usuario_hijos" value="si">
                                        <label for="hijos_si">Si</label>
                                        <input id="hijos_no" type="radio" name="usuario_hijos" value="no" checked>
                                        <label for="hijos_no">No</label>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-12 col-sm-6 my-2 text-center">
                                    <strong>-> Interes en... <-</strong>
                                    <select name="usuario_interes">
                                        <?php
                                        switch ($preferencia6->getValue()) {
                                            case 'Hombres':
                                                ?>
                                                <option selected>Hombres</option>
                                                <option>Mujeres</option>
                                                <option>Ambos</option>
                                                <?php
                                                break;
                                            case 'Mujeres':
                                                ?>
                                                <option>Hombres</option>
                                                <option selected>Mujeres</option>
                                                <option>Ambos</option>
                                                <?php
                                                break;
                                            case 'Ambos':
                                                ?>
                                                <option>Hombres</option>
                                                <option>Mujeres</option>
                                                <option selected>Ambos</option>
                                                <?php
                                                break;
                                        }
                                        ?>

                                    </select>
                                </div>
                                <input class="btn btn-primary my-3" type="submit" name="actualizarPreferencias" value="Actualizar preferencias">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
