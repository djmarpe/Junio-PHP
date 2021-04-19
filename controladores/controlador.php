<?php

require_once '../Clases/Persona.php';
require_once '../Clases/Conexion.php';
require_once '../Clases/Preferencia.php';

session_abort();
session_start();
if (isset($_REQUEST['goToRegister'])) {
    header('Location: ../Vistas/register.php');
    die();
}

if (isset($_REQUEST['goToLogin'])) {
    header('Location: ../Vistas/login.php');
    die();
}

if (isset($_REQUEST['btn_register'])) {
    //Recogemos los datos del formulario
    $name = $_REQUEST['register_name'];
    $surname = $_REQUEST['register_surname'];
    $email = $_REQUEST['register_email'];
    $passwd = $_REQUEST['register_passwd'];
    $fecNac = $_REQUEST['register_fecNac'];
    $country = $_REQUEST['register_country'];
    $city = $_REQUEST['register_city'];
    $sex = $_REQUEST['register_sex'];
    $description = $_REQUEST['register_description'];

    //Creamos el objeto persona
    $personaAux = new Persona();
    $personaAux->setId('null');
    $personaAux->setName($name);
    $personaAux->setSurname($surname);
    $personaAux->setEmail($email);
    $personaAux->setPasswd($passwd);
    $personaAux->setFecNac($fecNac);
    $personaAux->setCountry($country);
    $personaAux->setCity($city);
    $personaAux->setSex($sex);
    $personaAux->setDescription($description);
    $personaAux->setStatus(1);

    if (!Conexion::existeUsuario($email)) {
        if (Conexion::addUser($personaAux)) {
            $_SESSION['mensaje'] = 'Registro completado, inicie sesión';
            header('Location: ../Vistas/login.php');
        }
    } else {
        $_SESSION['mensaje'] = 'Error, no se puede registrar esta dirección de correo electrónico';
        header('Location: ../Vistas/register.php');
    }
    die();
}

if (isset($_REQUEST['btn_login'])) {

    $email = $_REQUEST['login_email'];
    $passwd = $_REQUEST['login_passwd'];

    if (Conexion::existeUsuario($email)) {
        if (Conexion::verificarInicioSesion($email, $passwd)) {
            $personaAux = Conexion::getUserLogin($email);
            Conexion::estadoOnline($personaAux->getId());
            $usuariosOnline = Conexion::getUsersOnline();
            $_SESSION['usuariosOnline'] = $usuariosOnline;
            $_SESSION['usuarioLogin'] = $personaAux;
            switch ($personaAux->getRol()) {
                case 'Administrador':
                    switch ($personaAux->getStatus()) {
                        case 1:
                            //Si es 1 (Primera vez que entra) vamos a seleccionar las preferencias.
                            header('Location: ../Vistas/preferenciasUsuario.php');
                            break;
                        case 2:
                            $listaUsuariosTotal = Conexion::getUsuariosRegistrados($personaAux->getId());
                            $listaAmigos = Conexion::getAmigos($personaAux->getId());
                            $userLogin_preferencias = Conexion::getPreferencias($personaAux->getId());
                            $_SESSION['userLogin_preferencias'] = $userLogin_preferencias;
                            $_SESSION['listaAmigos'] = $listaAmigos;
                            $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
                            header('Location: ../Vistas/panelPrincipalAdministrador.php');
                            break;
                    }
                    break;

                case 'Usuario':
                    //Comprobamos el estado del usuario
                    switch ($personaAux->getStatus()) {
                        case 1:
                            //Si es 1 (Primera vez que entra) vamos a seleccionar las preferencias.
                            header('Location: ../Vistas/preferenciasUsuario.php');
                            break;
                        case 2:
                            $listaAmigos = Conexion::getAmigos($personaAux->getId());
                            $userLogin_preferencias = Conexion::getPreferencias($personaAux->getId());
                            $_SESSION['userLogin_preferencias'] = $userLogin_preferencias;
                            $_SESSION['listaAmigos'] = $listaAmigos;
                            header('Location: ../Vistas/panelPrincipalUsuario.php');
                            break;
                    }
                    break;
            }
        } else {
            $_SESSION['mensaje'] = 'Usuario y/o contraseña incorrectos';
            header('Location: ../Vistas/login.php');
        }
    } else {
        $_SESSION['mensaje'] = 'No se encuentra el usuario';
        header('Location: ../Vistas/login.php');
    }
}

if (isset($_REQUEST['btn_completarLogin'])) {
    $userLogin_preferencias = [];
    $usuarioLogin = $_SESSION['usuarioLogin'];
    $preferencia_relacionSeria = $_REQUEST['preferencia_relacionSeria'];
    $preferencia_deporte = $_REQUEST['preferencia_deporte'];
    $preferencia_arte = $_REQUEST['preferencia_arte'];
    $preferencia_politica = $_REQUEST['preferencia_politica'];
    $preferencia_hijos = $_REQUEST['preferencia_hijos'];
    $preferencia_interes = $_REQUEST['preferencia_interes'];

    $preferencia1 = new Preferencia();
    $preferencia1->setIdUsuario($usuarioLogin->getId());
    $preferencia1->setType('relacion');
    $preferencia1->setValue($preferencia_relacionSeria);
    Conexion::addPreferencia($preferencia1);

    $preferencia2 = new Preferencia();
    $preferencia2->setIdUsuario($usuarioLogin->getId());
    $preferencia2->setType('deporte');
    $preferencia2->setValue($preferencia_deporte);
    Conexion::addPreferencia($preferencia2);

    $preferencia3 = new Preferencia();
    $preferencia3->setIdUsuario($usuarioLogin->getId());
    $preferencia3->setType('arte');
    $preferencia3->setValue($preferencia_arte);
    Conexion::addPreferencia($preferencia3);

    $preferencia4 = new Preferencia();
    $preferencia4->setIdUsuario($usuarioLogin->getId());
    $preferencia4->setType('politica');
    $preferencia4->setValue($preferencia_politica);
    Conexion::addPreferencia($preferencia4);

    $preferencia5 = new Preferencia();
    $preferencia5->setIdUsuario($usuarioLogin->getId());
    $preferencia5->setType('hijo');
    $preferencia5->setValue($preferencia_hijos);
    Conexion::addPreferencia($preferencia5);

    $preferencia6 = new Preferencia();
    $preferencia6->setIdUsuario($usuarioLogin->getId());
    $preferencia6->setType('interes');
    $preferencia6->setValue($preferencia_interes);
    Conexion::addPreferencia($preferencia6);

    //Guardamos las preferencias en la session
    $userLogin_preferencias[] = $preferencia1;
    $userLogin_preferencias[] = $preferencia2;
    $userLogin_preferencias[] = $preferencia3;
    $userLogin_preferencias[] = $preferencia4;
    $userLogin_preferencias[] = $preferencia5;
    $userLogin_preferencias[] = $preferencia6;

    $_SESSION['userLogin_preferencias'] = $userLogin_preferencias;
    $listaAmigos = Conexion::getAmigos($usuarioLogin->getId());
    $_SESSION['listaAmigos'] = $listaAmigos;
    $usuariosOnline = Conexion::getUsersOnline();
    $_SESSION['usuariosOnline'] = $usuariosOnline;
    switch ($usuarioLogin->getRol()) {
        case 'Usuario':
            header('Location: ../Vistas/panelPrincipalUsuario.php');
            break;
        case 'Administrador':
            header('Location: ../Vistas/panelPrincipalAdministrador.php');
            break;
    }
}

if (isset($_REQUEST['cerrarSesion'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];
    Conexion::estadoOffline($usuarioLogin->getId());
    if (isset($_SESSION['mensaje'])) {
        unset($_SESSION['mensaje']);
    }
    if (isset($_usuarioLogin)) {
        unset($_SESSION['usuarioLogin']);
    }
    if (isset($_SESSION['userLogin_preferencias'])) {
        unset($_SESSION['userLogin_preferencias']);
    }
    if (isset($_SESSION['listaAmigos'])) {
        unset($_SESSION['listaAmigos']);
    }
    if (isset($_SESSION['usuariosOnline'])) {
        unset($_SESSION['usuariosOnline']);
    }
    header('Location: ../index.php');
}

if (isset($_REQUEST['verGenteCercana'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];

    //Obtenemos las preferencias del usuario que ha iniciado sesión

    $preferencias_usuarioLogin = $_SESSION['userLogin_preferencias'];

    Conexion::getGenteCercana($preferencias_usuarioLogin);
}

if (isset($_REQUEST['administrarUsuarios'])) {
    header('Location: ../Vistas/administradorUsuarios.php');
}

if (isset($_REQUEST['dashboardAdmin'])) {
    $personaAux = $_SESSION['usuarioLogin'];
    $listaUsuariosTotal = Conexion::getUsuariosRegistrados($personaAux->getId());
    $listaAmigos = Conexion::getAmigos($personaAux->getId());
    $userLogin_preferencias = Conexion::getPreferencias($personaAux->getId());
    $_SESSION['userLogin_preferencias'] = $userLogin_preferencias;
    $_SESSION['listaAmigos'] = $listaAmigos;
    $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
    header('Location: ../Vistas/panelPrincipalAdministrador.php');
}

if (isset($_REQUEST['admin_newUser'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];

    $personaAux = new Persona();
    $personaAux->setName($_REQUEST['user_newName']);
    $personaAux->setSurname($_REQUEST['user_newSurname']);
    $personaAux->setEmail($_REQUEST['user_newEmail']);
    $personaAux->setPasswd(['user_newPasswd']);
    $personaAux->setFecNac($_REQUEST['user_newFecNac']);
    $personaAux->setCountry($_REQUEST['user_newCountry']);
    $personaAux->setCity($_REQUEST['user_newCity']);
    $personaAux->setDescription($_REQUEST['user_newDescription']);
    switch ($_REQUEST['user_newSex']) {
        case 'Hombre':
            $personaAux->setSex(1);
            break;
        case 'Mujer':
            $personaAux->setSex(2);
            break;
    }
    switch ($_REQUEST['user_newRol']) {
        case 'Administrador':
            $personaAux->setRol(1);
            break;
        case 'Usuario':
            $personaAux->setRol(2);
            break;
    }

    if (!Conexion::existeUsuario($personaAux->getEmail())) {
        if (Conexion::addUserAdmin($personaAux)) {
            $listaUsuariosTotal = Conexion::getUsuariosRegistrados($usuarioLogin->getId());
            $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
            header('Location: ../Vistas/administradorUsuarios.php');
        }
    } else {
        $_SESSION['mensaje'] = 'Error, no se puede añadir al usuario';
        $listaUsuariosTotal = Conexion::getUsuariosRegistrados($usuarioLogin->getId());
        $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
        header('Location: ../Vistas/administradorUsuarios.php');
    }
}

if (isset($_REQUEST['admin_delUser'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];
    $idUsuario = $_REQUEST['persona_idUsuario'];

    if (Conexion::deleteUser($idUsuario)) {
        $listaUsuariosTotal = Conexion::getUsuariosRegistrados($usuarioLogin->getId());
        $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
        header('Location: ../Vistas/administradorUsuarios.php');
    }
}

if (isset($_REQUEST['admin_editUser'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];
    $persona  = new Persona();
    $persona->setId($_REQUEST['persona_idUsuario']);
    $persona->setName($_REQUEST['persona_name']);
    $persona->setSurname($_REQUEST['persona_surname']);
    $persona->setEmail($_REQUEST['persona_email']);
    $persona->setPasswd($_REQUEST['persona_passwd']);
    switch ($_REQUEST['persona_rol']){
        case 'Administrador':
            $persona->setRol(1);
            break;
        case 'Usuario':
            $persona->setRol(2);
            break;
    }
    
    if (Conexion::editUser($persona)) {
        $listaUsuariosTotal = Conexion::getUsuariosRegistrados($usuarioLogin->getId());
        $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
        header('Location: ../Vistas/administradorUsuarios.php');
    }
}
