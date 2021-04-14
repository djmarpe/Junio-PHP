<?php

session_abort();
session_start();

require_once '../Clases/Persona.php';
require_once '../Clases/Conexion.php';

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
    $personaAux->setPasswd($password);
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
            $_SESSION['usuarioLogin'] = $personaAux;
            switch ($personaAux->getRol()) {
                case 'Administrador':
                    //Redirigir a Admin
                    break;
                case 'Usuario':
                    //Comprobamos el estado del usuario
                    switch ($personaAux->getStatus()) {
                        case 1:
                            //Si es 1 (Primera vez que entra) vamos a seleccionar las preferencias.
                            header('Location: ../Vistas/preferenciasUsuario.php');
                            break;
                        case 2:
                            //Si ya está 100% funcional, vamos a su panel principal
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
    
}
