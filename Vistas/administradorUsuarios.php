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
        <title>Administrador de usuarios</title>
    </head>
    <body class="background-dark-blue">
        <?php
        require_once '../Clases/Persona.php';
        session_start();
        $usuarioLogin = $_SESSION['usuarioLogin'];
        $listaUsuariosTotal = [];
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
                        <li class="breadcrumb-item" aria-current="page"><a href="../controladores/controlador.php?dashboardAdmin=dashboardAdmin" class="text-decoration-underline text-dark">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrador de usuarios</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row m-3">
            <div class="col-12 bg-white">
                <div class="text-center my-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                        Agregar usuario
                    </button>

                    <?php
                    if (isset($_SESSION['mensaje'])) {
                        ?>
                        <small class="text-warning"><?= $_SESSION['mensaje'] ?></small>
                        <?php
                    }
                    ?>

                </div>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Crear un nuevo usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="../controladores/controlador.php">
                                    <div class="mb-2">
                                        <small>Nombre</small>
                                        <input type="text" name="user_newName" class="form-control" placeholder="Pedro">
                                    </div>

                                    <div class="my-2">
                                        <small>Apellidos</small>
                                        <input type="text" name="user_newSurname" class="form-control" placeholder="Fernández Torres">
                                    </div>

                                    <div class="my-2">
                                        <small>Email</small>
                                        <input type="email" name="user_newEmail" class="form-control" placeholder="pedro@gmail.com">
                                    </div>

                                    <div class="my-2">
                                        <small>Contraseña</small>
                                        <input type="password" name="user_newPasswd" class="form-control">
                                    </div>

                                    <div class="my-2">
                                        <small>Fecha de nacimiento</small>
                                        <input type="date" name="user_newFecNac" class="form-control">
                                    </div>

                                    <div class="my-2">
                                        <small>País</small>
                                        <input type="text" name="user_newCountry" class="form-control" placeholder="España">
                                    </div>

                                    <div class="my-2">
                                        <small>Localidad</small>
                                        <input type="text" name="user_newCity" class="form-control" placeholder="Puertollano">
                                    </div>

                                    <div class="my-2">
                                        <small>Descripción</small>
                                        <textarea name="user_newDescription" class="form-control" rows="5" placeholder="Soy una persona muy ..."></textarea>
                                    </div>

                                    <div class="my-2">
                                        <small>Sexo</small>
                                        <select name="user_newSex" class="form-control">
                                            <option>Hombre</option>
                                            <option>Mujer</option>
                                        </select>
                                    </div>

                                    <div class="my-2">
                                        <small>Rol</small>
                                        <select name="user_newRol" class="form-control">
                                            <option>Usuario</option>
                                            <option>Administrador</option>
                                        </select>
                                    </div>

                                    <input type="submit" class="btn btn-primary my-2" value="Crear usuario" name="admin_newUser">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="my-3">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo electrónico</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < sizeof($listaUsuariosTotal); $i++) {
                        $persona = $listaUsuariosTotal[$i];
                        ?>
                        <form action="../controladores/controlador.php" method="POST">
                            <tr>
                            <input type="hidden" value="<?= $persona->getId() ?>" name="persona_idUsuario">
                            <td><input type="text" name="persona_name" value="<?= $persona->getName() ?>" class="form-control"></td>
                            <td><input type="text" name="persona_surname" value="<?= $persona->getSurname() ?>" class="form-control"></td>
                            <td><input type="email" name="persona_email" value="<?= $persona->getEmail() ?>" class="form-control"></td>
                            <td><input type="password" name="persona_passwd" placeholder="Nueva contraseña" class="form-control"></td>
                            <td>
                                <select name="persona_rol" class="form-control">
                                    <?php
                                    if ($persona->getRol() == 'Administrador') {
                                        ?>
                                        <option selected>Administrador</option>
                                        <option>Usuario</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option>Administrador</option>
                                        <option selected>Usuario</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <button class="btn p-0" type="submit" name="admin_editUser"><i class="fas fa-user-edit text-warning"></i></button>
                                <button class="btn p-0" type="submit" name="admin_delUser"><i class="fas fa-user-times text-danger"></i></button>
                            </td>
                            </tr>
                        </form>
                        <?php
                    }
                    ?>
                </table>

            </div>
        </div>
        <script src="../js/all.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>
