<?php

include_once 'Persona.php';
include_once 'Preferencia.php';
include_once 'UsuarioPreferencias.php';

class Conexion {

    public static $conexion;

    public static function abrirConex() {
        self::$conexion = new mysqli('localhost', 'alejandro', 'Chubaca2020', 'Junio-PHP');

        if (self::$conexion->connect_errno) {
            print "Fallo al conectar a MySQL: " . mysqli_connect_error();
        }
    }

    public static function cerrarConex() {
        mysqli_close(self::$conexion);
    }

    public static function existeUsuario($email) {
        //Abrimos conexion
        self::abrirConex();

        $existe = false;

        //Preparamos la consulta
        $consulta = 'SELECT * FROM user WHERE email=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param("s", $val1);
        $val1 = $email;
        $stmt->execute();

        //Ejecutamos la sentencia

        if ($resultado = $stmt->get_result()) {
            if ($row = $resultado->fetch_assoc()) {
                $existe = true;
            }
            mysqli_free_result($resultado);
        }

        //Cerramos conex
        self::cerrarConex();

        return $existe;
    }

    public static function addUser($personaAux) {
        //Abrimos conexion
        self::abrirConex();

        $add = false;
        $val9 = 0;

        $val1 = $personaAux->getName();
        $val2 = $personaAux->getSurname();
        $val3 = $personaAux->getEmail();
        $val4 = $personaAux->getPasswd();
        $val5 = $personaAux->getDescription();
        $val6 = $personaAux->getFecNac();
        $val7 = $personaAux->getCountry();
        $val8 = $personaAux->getCity();
        if ($personaAux->getSex() == 'Hombre') {
            $val9 = 1;
        } else {
            $val9 = 2;
        }
        $val10 = $personaAux->getStatus();
        $sentencia1 = "INSERT INTO user VALUES(null,'" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "','" . $val5 . "','" . $val6 . "','" . $val7 . "','" . $val8 . "'," . $val9 . "," . $val10 . ",0)";

        //Insertamos el usuario
        if (mysqli_query(self::$conexion, $sentencia1)) {
            //Si conseguimos añadirlo en la tabla usuario, obtenemos el id del usuario
            $sentencia2 = "SELECT id FROM user WHERE email = '" . $val3 . "'";
            if ($resultado = mysqli_query(self::$conexion, $sentencia2)) {
                if ($row = mysqli_fetch_array($resultado)) {
                    //Insertamos en la tabla rolAsignated
                    $sentencia3 = "INSERT INTO rolAsignated VALUES(" . $row[0] . "," . 2 . ")";
                    if (mysqli_query(self::$conexion, $sentencia3)) {
                        //Ponemos add a true =  usuario añadido.
                        $add = true;
                    }
                }
            }
        }
        self::cerrarConex();

        return $add;
    }

    public static function addUserAdmin($personaAux) {
        //Abrimos conexion
        self::abrirConex();

        $add = false;
        $val9 = 0;

        $val1 = $personaAux->getName();
        $val2 = $personaAux->getSurname();
        $val3 = $personaAux->getEmail();
        $val4 = $personaAux->getPasswd();
        $val5 = $personaAux->getDescription();
        $val6 = $personaAux->getFecNac();
        $val7 = $personaAux->getCountry();
        $val8 = $personaAux->getCity();
        $val9 = $personaAux->getSex();
        $sentencia1 = "INSERT INTO user VALUES(null,'" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "','" . $val5 . "','" . $val6 . "','" . $val7 . "','" . $val8 . "'," . $val9 . ",1,0)";

        //Insertamos el usuario
        if (mysqli_query(self::$conexion, $sentencia1)) {
            //Si conseguimos añadirlo en la tabla usuario, obtenemos el id del usuario
            $sentencia2 = "SELECT id FROM user WHERE email = '" . $val3 . "'";
            if ($resultado = mysqli_query(self::$conexion, $sentencia2)) {
                if ($row = mysqli_fetch_array($resultado)) {
                    //Insertamos en la tabla rolAsignated
                    switch ($personaAux->getRol()) {
                        case 1:
                            $sentencia3 = "INSERT INTO rolAsignated VALUES(" . $row[0] . ",1)";
                            if (mysqli_query(self::$conexion, $sentencia3)) {
                                //Ponemos add a true =  usuario añadido.
                                $add = true;
                            }
                            break;
                        case 2:
                            $sentencia3 = "INSERT INTO rolAsignated VALUES(" . $row[0] . ",2)";
                            if (mysqli_query(self::$conexion, $sentencia3)) {
                                //Ponemos add a true =  usuario añadido.
                                $add = true;
                            }
                            break;
                    }
                }
            }
        }
        self::cerrarConex();

        return $add;
    }

    public static function verificarInicioSesion($email, $passwd) {
        self::abrirConex();
        $ok = false;

        //Preparamos la consulta
        $consulta = 'SELECT * FROM user WHERE email=? AND passwd=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param("ss", $val1, $val2);
        $val1 = $email;
        $val2 = $passwd;
        $stmt->execute();

        //Ejecutamos la sentencia
        if ($resultado = $stmt->get_result()) {
            if ($row = $resultado->fetch_assoc()) {
                if ($email == $row[email] && $passwd == $row[passwd]) {
                    $ok = true;
                }
            }
            mysqli_free_result($resultado);
        }

        self::cerrarConex();
        return $ok;
    }

    public static function getUserLogin($email) {
        self::abrirConex();
        $personaAux = null;

        //Preparamos la consulta
        $consulta = 'SELECT * FROM user WHERE email=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param("s", $val1);
        $val1 = $email;
        $stmt->execute();

        //Ejecutamos la sentencia
        if ($resultado = $stmt->get_result()) {
            if ($row = mysqli_fetch_array($resultado)) {
                $personaAux = new Persona();
                $personaAux->setId($row[0]);
                $personaAux->setName($row[1]);
                $personaAux->setSurname($row[2]);
                $personaAux->setEmail($row[3]);
                $personaAux->setPasswd($row[4]);
                $personaAux->setDescription($row[5]);
                $personaAux->setFecNac($row[6]);
                $personaAux->setCountry($row[7]);
                $personaAux->setCity($row[8]);
                switch ($row[9]) {
                    case 1:
                        $personaAux->setSex('Hombre');
                        break;
                    case 2:
                        $personaAux->setSex('Mujer');
                        break;
                }
                $personaAux->setStatus($row[10]);

                //Preparamos la consulta
                $consulta = 'SELECT * FROM rolAsignated WHERE idUsuario=?';
                $stmt = self::$conexion->prepare($consulta);
                $stmt->bind_param("i", $val1);
                $val1 = $personaAux->getId();
                $stmt->execute();
                if ($resultado = $stmt->get_result()) {
                    if ($row = mysqli_fetch_array($resultado)) {
                        switch ($row[1]) {
                            case 1:
                                $personaAux->setRol('Administrador');
                                break;
                            case 2:
                                $personaAux->setRol('Usuario');
                                break;
                        }
                    }
                }
            }
            mysqli_free_result($resultado);
        }

        self::cerrarConex();
        return $personaAux;
    }

    public static function addPreferencia($preferencia) {
        self::abrirConex();
        $ok = false;

        $sentencia1 = "INSERT INTO preferences VALUES(null," . $preferencia->getIdUsuario() . ",'" . $preferencia->getType() . "','" . $preferencia->getValue() . "')";

        if (mysqli_query(self::$conexion, $sentencia1)) {
            $sentencia2 = "UPDATE user SET status = 2 WHERE id = " . $preferencia->getIdUsuario();
            if (mysqli_query(self::$conexion, $sentencia2)) {
                $ok = true;
            }
        }

        self::cerrarConex();
    }

    public static function getAmigos($idUsuario) {
        self::abrirConex();

        $listaAmigos = [];

        $sentencia = "SELECT * FROM friends WHERE idUsuarioEmitter=? AND status=1";

        $stmt = self::$conexion->prepare($sentencia);
        $stmt->bind_param("i", $val1);
        $val1 = $idUsuario;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = mysqli_fetch_array($resultado)) {
                $idUsuarioReceptor = $row[1];
                $sentencia2 = "SELECT * FROM user WHERE id=" . $idUsuarioReceptor;
                if ($resultado2 = mysqli_query(self::$conexion, $sentencia2)) {
                    if ($fila = mysqli_fetch_array($resultado2)) {
                        $amigoAux = new Persona();
                        $amigoAux->setId($fila[0]);
                        $amigoAux->setName($fila[1]);
                        $amigoAux->setSurname($fila[2]);
                        $amigoAux->setEmail($fila[3]);
                        $amigoAux->setPasswd($fila[4]);
                        $amigoAux->setDescription($fila[5]);
                        $amigoAux->setFecNac($fila[6]);
                        $amigoAux->setCountry($fila[7]);
                        $amigoAux->setCity($fila[8]);
                        switch ($fila[9]) {
                            case 1:
                                $amigoAux->setSex('Hombre');
                                break;
                            case 2:
                                $amigoAux->setSex('Mujer');
                                break;
                        }
                        $amigoAux->setStatus($fila[10]);
                        $listaAmigos[] = $amigoAux;
                    }
                }
            }
        }

        self::cerrarConex();
        return $listaAmigos;
    }

    public static function estadoOnline($idUsuario) {
        self::abrirConex();

        $sentencia = "UPDATE user SET online = 1 WHERE id = " . $idUsuario;

        mysqli_query(self::$conexion, $sentencia);

        self::cerrarConex();
    }

    public static function estadoOffline($idUsuario) {
        self::abrirConex();

        $sentencia = "UPDATE user SET online = 0 WHERE id = " . $idUsuario;

        mysqli_query(self::$conexion, $sentencia);

        self::cerrarConex();
    }

    public static function getUsersOnline() {
        self::abrirConex();
        $cuantos = 0;

        $sentencia = "SELECT count(online) FROM user WHERE online = 1";

        if ($resultado = mysqli_query(self::$conexion, $sentencia)) {
            if ($row = mysqli_fetch_array($resultado)) {
                $cuantos = $row[0];
            }
        }

        self::cerrarConex();
        return $cuantos;
    }

    public static function getPreferencias($idUsuario) {
        self::abrirConex();

        $listaPreferencias = [];

        $sentencia = "SELECT * FROM preferences WHERE idUsuario=" . $idUsuario;

        if ($resultado = mysqli_query(self::$conexion, $sentencia)) {
            while ($row = mysqli_fetch_array($resultado)) {
                $preferenciaAux = new Preferencia();
                $preferenciaAux->setId($row[0]);
                $preferenciaAux->setIdUsuario($idUsuario);
                $preferenciaAux->setType($row[2]);
                $preferenciaAux->setValue($row[3]);
                $listaPreferencias[] = $preferenciaAux;
            }
        }

        self::cerrarConex();
        return $listaPreferencias;
    }

    public static function getUsuariosRegistrados($idUsuarioLogin) {
        self::abrirConex();

        $listaUsuarios = [];

        $sentencia = "SELECT * FROM user WHERE id <> ?";

        $stmt = self::$conexion->prepare($sentencia);
        $stmt->bind_param("i", $val1);
        $val1 = $idUsuarioLogin;
        $stmt->execute();
        if ($resultado1 = $stmt->get_result()) {
            while ($row = mysqli_fetch_array($resultado1)) {
                $personaAux = new Persona();
                $personaAux->setId($row[0]);
                $personaAux->setName($row[1]);
                $personaAux->setSurname($row[2]);
                $personaAux->setEmail($row[3]);
                $personaAux->setPasswd($row[4]);
                $personaAux->setDescription($row[5]);
                $personaAux->setFecNac($row[6]);
                $personaAux->setCountry($row[7]);
                $personaAux->setCity($row[8]);
                switch ($row[9]) {
                    case 1:
                        $personaAux->setSex('Hombre');
                        break;
                    case 2:
                        $personaAux->setSex('Mujer');
                        break;
                }
                $personaAux->setStatus($row[10]);

                $sentencia2 = "SELECT idRol FROM rolAsignated WHERE idUsuario = " . $personaAux->getId();

                if ($resultado2 = mysqli_query(self::$conexion, $sentencia2)) {
                    if ($row2 = mysqli_fetch_array($resultado2)) {
                        switch ($row2[0]) {
                            case 1:
                                $personaAux->setRol('Administrador');
                                break;
                            case 2:
                                $personaAux->setRol('Usuario');
                                break;
                        }
                        $listaUsuarios[] = $personaAux;
                    }
                }
            }
        }

        self::cerrarConex();
        return $listaUsuarios;
    }

    public static function getGenteCercana($preferencias_usuarioLogin) {
        self::abrirConex();

        $usuariosCandidatos = [];

        $preferencia1 = $preferencias_usuarioLogin[0]; // si/no
        $preferencia2 = $preferencias_usuarioLogin[1];
        $preferencia3 = $preferencias_usuarioLogin[2];
        $preferencia4 = $preferencias_usuarioLogin[3];
        $preferencia5 = $preferencias_usuarioLogin[4]; // si/no
        $preferencia6 = $preferencias_usuarioLogin[5]; // hombres/mujeres/ambos
        $sentencia1 = "";

        switch ($preferencia6->getValue()) {
            case 'Hombres':
                $sentencia1 = "SELECT DISTINCT(idUsuario) FROM preferences WHERE (tipo = 'relacion' or tipo = 'hijo' or tipo = 'interes') AND (value = '" . $preferencia1->getValue() . "' or value='Mujeres')";
                break;
            case 'Mujeres':
                $sentencia1 = "SELECT DISTINCT(idUsuario) FROM preferences WHERE (tipo = 'relacion' or tipo = 'hijo' or tipo = 'interes') AND (value = '" . $preferencia1->getValue() . "' or value='Hombres')";
                break;
            case 'Ambos':
                $sentencia1 = "SELECT DISTINCT(idUsuario) FROM preferences WHERE (tipo = 'relacion' or tipo = 'hijo' or tipo = 'interes') AND (value = '" . $preferencia1->getValue() . "' or value='Ambos')";
                break;
        }

        if ($resultado1 = mysqli_query(self::$conexion, $sentencia1)) {
            while ($row = mysqli_fetch_array($resultado1)) {
                $usuarioCandidatoAux = new UsuarioPreferencias();
                $idUsuarioCandidato = $row[0];
                $sentencia2 = "Select * from user Where id = " . $idUsuarioCandidato;
                if ($resultado2 = mysqli_query(self::$conexion, $sentencia2)) {
                    if ($row2 = mysqli_fetch_array($resultado2)) {
                        $usuarioCandidatoAux->setIdUsuario($row2[0]);
                    }
                }
            }
        }

        self::cerrarConex();
    }

    public static function deleteUser($idUsuario) {
        self::abrirConex();
        $del = false;

        $sentencia1 = "DELETE FROM user WHERE id = " . $idUsuario;

        if ($resultado1 = mysqli_query(self::$conexion, $sentencia1)) {
            $sentencia2 = "DELETE FROM rolAsignated WHERE idUsuario = " . $idUsuario;
            if ($resultado2 = mysqli_query(self::$conexion, $sentencia2)) {
                $del = true;
            }
        }

        self::cerrarConex();
        return $del;
    }

    public static function editUser($persona) {
        self::abrirConex();
        $ok = true;

        if ($persona->getPasswd() == '') {
            $sentencia1 = "Update user SET name = '" . $persona->getName() . "', surname = '" . $persona->getSurname() . "', email = '" . $persona->getEmail() . "' WHERE id = " . $persona->getId();
            if (mysqli_query(self::$conexion, $sentencia1)) {
                $sentencia2 = "Update rolAsignated SET idRol = " . $persona->getRol() . " WHERE idUsuario = " . $persona->getId();
                if (mysqli_query(self::$conexion, $sentencia2)) {
                    $ok = true;
                }
            }
        } else {
            $sentencia1 = "Update user SET name = '" . $persona->getName() . "', surname = '" . $persona->getSurname() . "', email = '" . $persona->getEmail() . "', passwd = '" . $persona->getPasswd() . "' WHERE id = " . $persona->getId();
            if (mysqli_query(self::$conexion, $sentencia1)) {
                $sentencia2 = "Update rolAsignated SET idRol = " . $persona->getRol() . " WHERE idUsuario = " . $persona->getId();
                if (mysqli_query(self::$conexion, $sentencia2)) {
                    $ok = true;
                }
            }
        }

        self::cerrarConex();
        return $ok;
    }

}
