<?php

require_once '../Clases/Persona.php';
require_once '../Clases/Conexion.php';
require_once '../Clases/Preferencia.php';
require_once '../Clases/Mensaje.php';

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

if ($_REQUEST['leerMensaje']) {
    $idMensaje = $_REQUEST['idMensaje'];
    $usuarioLogin = $_SESSION['usuarioLogin'];

    if (Conexion::leerMensaje($idMensaje)) {
        $listaMensajesRecibidos = Conexion::getMensajesRebidosUsuario($usuarioLogin->getId());
        $_SESSION['mensajesRecibidos'] = $listaMensajesRecibidos;
        $_SESSION['estoyEn'] = 'verMensajesRecibidos';
        header('Location: ../Vistas/verMensajesRecibidos.php');
    }
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
    $usuariosCandidatos = [];

    $usuarioLogin = $_SESSION['usuarioLogin'];

    //Obtenemos los datos del usuario login (usuario clave)
    $usuarioLoginPreferencias = new UsuarioPreferencias();
    $usuarioLoginPreferencias->setIdUsuario($usuarioLogin->getId());
    $usuarioLoginPreferencias->setNombreUsuario($usuarioLogin->getName());
    $usuarioLoginPreferencias->setApellidosUsuario($usuarioLogin->getSurname());
    $usuarioLoginPreferencias->setFechaNacimientoUsuario($usuarioLogin->getFecNac());
    $usuarioLoginPreferencias->setDescripcion($usuarioLogin->getDescription());
    $usuarioLoginPreferencias->setEmail($usuarioLogin->getEmail());
    $usuarioLoginPreferencias->setPais($usuarioLogin->getCountry());
    $usuarioLoginPreferencias->setLocalidad($usuarioLogin->getCity());
    $usuarioLoginPreferencias->setSexo($usuarioLogin->getSex());
    //Obtenemos las preferencias del usuario
    $usuarioLoginPreferencias->setPreferencias(Conexion::getUsuarioLoginPreferencias($usuarioLogin->getId()));
    $preferenciasUsuarioLogin = $usuarioLoginPreferencias->getPreferencias();

    $_SESSION['usuarioPrincipal'] = $usuarioLoginPreferencias;

    $listaTotalUsuarios = Conexion::getUsuariosTotal($usuarioLogin->getId());

    for ($i = 0; $i < sizeof($listaTotalUsuarios); $i++) {
        $usuarioAux = $listaTotalUsuarios[$i];
        $preferenciasUsuarioAux = $usuarioAux->getPreferencias();
        $posible = 0; //Este el contador que va a decir si es un posible candidato o no
        $claves = 0; //Este es el contador que va a marcar si los introduce o no
        for ($k = 0; $k < sizeof($preferenciasUsuarioAux); $k++) {
            $preferenciaLogin = $preferenciasUsuarioLogin[$k];
            $preferenciaAux = $preferenciasUsuarioAux[$k];
            switch ($preferenciaAux->getType()) {
                case 'relacion':
                    if ($preferenciaAux->getValue() == $preferenciaLogin->getValue()) {
                        $claves++;
                    }
                    break;
                case 'deporte':
                    if ($preferenciaAux->getValue() + 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() - 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() == $preferenciaLogin->getValue()) {
                        $posible++;
                    }
                    break;
                case 'arte':
                    if ($preferenciaAux->getValue() + 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() - 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() == $preferenciaLogin->getValue()) {
                        $posible++;
                    }
                    break;
                case 'politica':
                    if ($preferenciaAux->getValue() + 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() - 1 == $preferenciaLogin->getValue() || $preferenciaAux->getValue() == $preferenciaLogin->getValue()) {
                        $posible++;
                    }
                    break;
                case 'hijo':
                    if ($preferenciaAux->getValue() == $preferenciaLogin->getValue()) {
                        $claves++;
                    }
                    break;
                case 'interes':
                    if ($preferenciaLogin->getValue() == 'Ambos' && ($usuarioAux->getSexo() == 'Hombres' || $usuarioAux->getSexo() == 'Mujeres')) {
                        $claves++;
                    }
                    if ($preferenciaLogin->getValue() == 'Mujeres' && $usuarioAux->getSexo() == 'Mujer' && ($preferenciaAux->getValue() == 'Hombres' || $preferenciaAux->getValue() == 'Ambos')) {
                        $claves++;
                    }
                    if ($preferenciaLogin->getValue() == 'Hombres' && $usuarioAux->getSexo() == 'Hombre' && ($preferenciaAux->getValue() == 'Mujeres' || $preferenciaAux->getValue() == 'Ambos')) {
                        $claves++;
                    }
                    if ($preferenciaLogin->getValue() == 'Mujeres' && $usuarioAux->getSexo() == 'Mujer' && ($preferenciaAux->getValue() == 'Mujeres' || $preferenciaAux->getValue() == 'Ambos')) {
                        $claves++;
                    }
                    if ($preferenciaLogin->getValue() == 'Hombres' && $usuarioAux->getSexo() == 'Hombre' && ($preferenciaAux->getValue() == 'Hombres' || $preferenciaAux->getValue() == 'Ambos')) {
                        $claves++;
                    }
                    break;
            }
        }
        if ($claves == 3 && $posible >= 2) {
            $usuariosCandidatos[] = $listaTotalUsuarios[$i];
        }
    }
    $_SESSION['usuariosCandidatos'] = $usuariosCandidatos;
    if (isset($_SESSION['mensaje'])) {
        unset($_SESSION['mensaje']);
    }
    header('Location: ../Vistas/genteCercana.php');
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
    if (isset($_SESSION['mensajesRecibidos'])) {
        unset($_SESSION['mensajesRecibidos']);
    }
    header('Location: ../Vistas/panelPrincipalAdministrador.php');
}

if (isset($_REQUEST['dashboardUsuario'])) {
    $personaAux = $_SESSION['usuarioLogin'];
    $listaUsuariosTotal = Conexion::getUsuariosRegistrados($personaAux->getId());
    $listaAmigos = Conexion::getAmigos($personaAux->getId());
    $userLogin_preferencias = Conexion::getPreferencias($personaAux->getId());
    $_SESSION['userLogin_preferencias'] = $userLogin_preferencias;
    $_SESSION['listaAmigos'] = $listaAmigos;
    $_SESSION['listaUsuariosTotal'] = $listaUsuariosTotal;
    header('Location: ../Vistas/panelPrincipalUsuario.php');
}

if (isset($_REQUEST['verMatch'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];
    $usuariosCandidatos = $_SESSION['usuariosCandidatos'];
    $idUsuarioVer = $_REQUEST['idUsuario'];
    for ($i = 0; $i < sizeof($usuariosCandidatos); $i++) {
        $usuarioAux = $usuariosCandidatos[$i];
        if ($usuarioAux->getIdUsuario() == $idUsuarioVer) {
            $elegido = $usuariosCandidatos[$i];
            $_SESSION['usuarioElegido'] = $elegido;
        }
    }
    header('Location: ../Vistas/verMatch.php');
}

if (isset($_REQUEST['admin_newUser'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];

    $personaAux = new Persona();
    $personaAux->setName($_REQUEST['user_newName']);
    $personaAux->setSurname($_REQUEST['user_newSurname']);
    $personaAux->setEmail($_REQUEST['user_newEmail']);
    $personaAux->setPasswd($_REQUEST['user_newPasswd']);
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
    $persona = new Persona();
    $persona->setId($_REQUEST['persona_idUsuario']);
    $persona->setName($_REQUEST['persona_name']);
    $persona->setSurname($_REQUEST['persona_surname']);
    $persona->setEmail($_REQUEST['persona_email']);
    $persona->setPasswd($_REQUEST['persona_passwd']);
    switch ($_REQUEST['persona_rol']) {
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

if (isset($_REQUEST['enviarMensaje'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];
    $idUsuarioEmisor = $usuarioLogin->getId();
    $idUsuarioReceptor = Conexion::getIdUsuario($_REQUEST['email_to']);
    $asunto = $_REQUEST['subject'];
    $cuerpo = $_REQUEST['body'];

    $mensaje = new Mensaje();
    $mensaje->setIdUsuarioEmisor($idUsuarioEmisor);
    $mensaje->setIdUsuarioReceptor($idUsuarioReceptor);
    $mensaje->setAsunto($asunto);
    $mensaje->setCuerpo($cuerpo);
    $mensaje->setLeido(0);

    if (Conexion::enviarMensaje($mensaje)) {
        $_SESSION['mensaje'] = 'Mensaje enviado correctamente';
        switch ($_SESSION['estoyEn']) {
            case 'verMensajesEnviados':
                $listaMensajesEnviados = Conexion::getMensajesEnviadosUsuario($usuarioLogin->getId());
                $_SESSION['mensajesEnviados'] = $listaMensajesEnviados;
                header('Location: ../Vistas/verMensajesEnviados.php');
                break;
            case 'verMensajesRecibidos':
                $listaMensajesRecibidos = Conexion::getMensajesRebidosUsuario($usuarioLogin->getId());
                $_SESSION['mensajesRecibidos'] = $listaMensajesRecibidos;
                header('Location: ../Vistas/verMensajesRecibidos.php');
                break;
            default :header('Location: ../Vistas/verMatch.php');
        }
    }
}

if (isset($_REQUEST['verMensajesEnviados'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];

    $listaMensajesEnviados = Conexion::getMensajesEnviadosUsuario($usuarioLogin->getId());

    $_SESSION['mensajesEnviados'] = $listaMensajesEnviados;
    $_SESSION['estoyEn'] = 'verMensajesEnviados';
    header('Location: ../Vistas/verMensajesEnviados.php');
}

if (isset($_REQUEST['verMensajesRecibidos'])) {
    $usuarioLogin = $_SESSION['usuarioLogin'];

    $listaMensajesRecibidos = Conexion::getMensajesRebidosUsuario($usuarioLogin->getId());

    $_SESSION['mensajesRecibidos'] = $listaMensajesRecibidos;
    $_SESSION['estoyEn'] = 'verMensajesRecibidos';
    header('Location: ../Vistas/verMensajesRecibidos.php');
}
