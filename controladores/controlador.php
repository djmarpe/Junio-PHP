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
    $_SESSION['userLogin_pref1'] = $preferencia1;
    $_SESSION['userLogin_pref2'] = $preferencia2;
    $_SESSION['userLogin_pref3'] = $preferencia3;
    $_SESSION['userLogin_pref4'] = $preferencia4;
    $_SESSION['userLogin_pref5'] = $preferencia5;
    $_SESSION['userLogin_pref6'] = $preferencia6;
    
    
}
