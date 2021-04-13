<?php

include_once './Persona.php';

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
        $sentencia1 = "INSERT INTO user VALUES(null,'" . $val1 . "','" . $val2 . "','" . $val3 . "','" . $val4 . "','" . $val5 . "','" . $val6 . "','" . $val7 . "','" . $val8 . "'," . $val9 . "," . $val10 . ")";

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

    public static function getRol($dni) {
        self::abrirConex();

        $consulta = 'SELECT id FROM asignacion WHERE dni=?';

        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $dni;
        $stmt->execute();

        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $res = $row['id'];
            }
        }
        self::cerrarConex();

        return $res;
    }

    public static function getActivado($dni) {
        self::abrirConex();

        $consulta = 'SELECT activado FROM usuarios WHERE dni=?';

        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $dni;
        $stmt->execute();

        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $res = $row['activado'];
            }
        }

        self::cerrarConex();
        return $res;
    }

    public static function setRol($dni, $rol) {
        self::abrirConex();

        $consulta = 'UPDATE usuarios set activado=? where dni=?';

        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('is', $val1, $val2);
        $val1 = $rol;
        $val2 = $dni;
        $stmt->execute();
        self::cerrarConex();
    }

    public static function delUser($dni) {
        self::abrirConex();

        $consulta = 'DELETE FROM usuarios WHERE dni=?';

        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $dni;
        $stmt->execute();
        self::cerrarConex();
    }

    public static function editUser($dni, $mail, $pass, $nombre, $apellido, $rol) {
        self::abrirConex();

        if ($pass != null) {
            $consulta1 = 'UPDATE usuarios SET mail=? , pass=? , nombre=? , apellido=? WHERE dni=?';
            $stmt1 = self::$conexion->prepare($consulta1);
            $stmt1->bind_param('sssss', $val1, $val2, $val3, $val4, $val5);
            $val1 = $mail;
            $val2 = $pass;
            $val3 = $nombre;
            $val4 = $apellido;
            $val5 = $dni;
            $stmt1->execute();
        } else {
            $consulta1 = 'UPDATE usuarios SET mail=? , nombre=? , apellido=? WHERE dni=?';
            $stmt1 = self::$conexion->prepare($consulta1);
            $stmt1->bind_param('ssss', $val1, $val2, $val3, $val4);
            $val1 = $mail;
            $val2 = $nombre;
            $val3 = $apellido;
            $val4 = $dni;
            $stmt1->execute();
        }

        $consulta2 = 'UPDATE asignacion SET id=? WHERE dni=?';
        $stmt2 = self::$conexion->prepare($consulta2);
        $stmt2->bind_param('is', $val6, $val7);
        $val6 = $rol;
        $val7 = $dni;
        $stmt2->execute();
        self::cerrarConex();
    }

    public static function alterPassword($dni, $pass) {
        self::abrirConex();

        $modified = false;

        $consulta = "UPDATE usuarios SET pass = '" . $pass . "' WHERE dni = '" . $dni . "'";

        if (mysqli_query(self::$conexion, $consulta)) {
            //Ponemos modified a true =  usuario modificado.
            $modified = true;
        }

        self::cerrarConex();
        return $modified;
    }

    public static function addPregunta($pregunta) {
        self::abrirConex();

        $add = false;

        $tipo = $pregunta->getTipo();
        //$idExamen = self::getIdExamen();
        $idExamen = -1;
        $descripcion = $pregunta->getDescripcion();
        $resp1 = $pregunta->getRespuesta1();
        $resp2 = $pregunta->getRespuesta2();
        $resp3 = $pregunta->getRespuesta3();
        $resp4 = $pregunta->getRespuesta4();
        $respCorrecta = $pregunta->getRespuestaCorrecta();

        $sentencia1 = "INSERT INTO preguntas VALUES(NULL, " . $idExamen . ",'" . $descripcion . "')";

        if (mysqli_query(self::$conexion, $sentencia1)) {
            $idPregunta = "SELECT idPregunta FROM preguntas where idExamen = " . $idExamen . " AND pregunta = '" . $descripcion . "'";

            if ($resultado = mysqli_query(self::$conexion, $idPregunta)) {
                if ($fila = mysqli_fetch_array($resultado)) {
                    $idPregunta = $fila[0];
                    $sentencia2 = "INSERT INTO respuestasCorrectas VALUES(" . $idPregunta . ",'" . $tipo . "','" . $resp1 . "','" . $resp2 . "','" . $resp3 . "','" . $resp4 . "','" . $respCorrecta . "')";
                    if (mysqli_query(self::$conexion, $sentencia2)) {
                        $add = true;
                    }
                }
            }
        }

        self::cerrarConex();
        return $add;
    }

    public static function getPreguntas() {
        $preguntasDisponibles = [];

        self::abrirConex();

        $sentencia = "SELECT * FROM preguntas WHERE idExamen = -1";
        if ($resultado = mysqli_query(self::$conexion, $sentencia)) {
            while ($fila = mysqli_fetch_row($resultado)) {
                $idPregunta = $fila[0];
                $idExamen = $fila[1];
                $descripcion = $fila[2];

                $queryTipo = "SELECT tipo FROM respuestasCorrectas WHERE idPregunta = " . $idPregunta;

                if ($resultadoTipo = mysqli_query(self::$conexion, $queryTipo)) {
                    if ($tipoPregunta = mysqli_fetch_row($resultadoTipo)) {
                        $tipo = $tipoPregunta[0];
                        $pregunta = new PreguntaAux($idPregunta, $idExamen, $descripcion, $tipo);
                        $preguntasDisponibles[] = $pregunta;
                    }
                }
            }
        }

        self::cerrarConex();
        return $preguntasDisponibles;
    }

    public static function getAllExamen() {
        self::abrirConex();

        $consulta = 'SELECT * FROM examen ORDER BY estado DESC';
        $res = array();

        if ($resultado = self::$conexion->query($consulta)) {
            while ($row = $resultado->fetch_assoc()) {
                $r = new Examen($row['id'], $row['id_Profesor'], $row['fecha_Inicio'], $row['fecha_Fin'], $row['estado'], $row['titulo'], $row['descripcion']);
                $res[] = $r;
            }
        }
        self::cerrarConex();
        return $res;
    }

    public static function examenOn($id) {
        self::abrirConex();

        $consulta = 'UPDATE examen SET estado=1 WHERE id=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function examenOff($id) {
        self::abrirConex();

        $consulta = 'UPDATE examen SET estado=0 WHERE id=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function editExamen($id, $titulo, $fecha_inicio, $fecha_fin, $descripcion) {
        self::abrirConex();

        $consulta = 'UPDATE examen SET titulo=? , fecha_Inicio=? , fecha_Fin=? , descripcion=? WHERE id=? ';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('ssssi', $val1, $val2, $val3, $val4, $val5);
        $val1 = $titulo;
        $val2 = $fecha_inicio;
        $val3 = $fecha_fin;
        $val4 = $descripcion;
        $val5 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function deleteExamen($id) {
        self::abrirConex();

        $consulta = 'DELETE FROM examen WHERE id=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function reabrirPreguntas($id) {
        self::abrirConex();

        $consulta = 'UPDATE preguntas SET idExamen = -1 WHERE idExamen =?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function checkExamen($id) {
        self::abrirConex();

        $consulta = 'UPDATE examen SET estado=2 WHERE id=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function getIdPregunta($pregunta) {
        self::abrirConex();
        $idPregunta;

        $sentencia = "SELECT idPregunta FROM preguntas WHERE pregunta = '" . $pregunta . "'";

        if ($resultado = mysqli_query(self::$conexion, $sentencia)) {
            if ($fila = mysqli_fetch_array($resultado)) {
                $idPregunta = $fila[0];
            }
        }
        self::cerrarConex();
        return $idPregunta;
    }

    public static function addExamen($examen) {
        self::abrirConex();
        $add = false;

        $idProfesor = $examen->getId_Profesor();
        $titulo = $examen->getTitulo();
        $descripcion = $examen->getDescripcion();

        $sentencia = "INSERT INTO examen values(NULL,'" . $idProfesor . "',default,default,0,'" . $titulo . "','" . $descripcion . "')";

        if (mysqli_query(self::$conexion, $sentencia)) {
            $add = true;
        }

        self::cerrarConex();
        return $add;
    }

    public static function getIdExamen($dniProfesor, $titulo) {
        self::abrirConex();
        $idExamen;

        $sentencia = "SELECT id FROM examen WHERE id_Profesor = '" . $dniProfesor . "' AND titulo = '" . $titulo . "'";

        if ($resultado = mysqli_query(self::$conexion, $sentencia)) {
            if ($fila = mysqli_fetch_array($resultado)) {
                $idExamen = $fila[0];
            }
        }

        self::cerrarConex();
        return $idExamen;
    }

    public static function asignarPreguntasAExamen($idExamen, $idPregunta) {
        self::abrirConex();
        $asignados = false;

        $sentencia = "UPDATE preguntas SET idExamen = " . $idExamen . " WHERE idPregunta = " . $idPregunta;

        if (mysqli_query(self::$conexion, $sentencia)) {
            $asignados = true;
        }
    }

    public static function getExamen($id) {
        self::abrirConex();

        $consulta = 'SELECT * FROM examen WHERE id=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();

        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = new Examen($row['id'], $row['id_Profesor'], $row['fecha_Inicio'], $row['fecha_Fin'], $row['estado'], $row['titulo'], $row['descripcion']);
            }
        }
        self::cerrarConex();
        return $r;
    }

    public static function getPreguntasExamen($id) {
        $preguntasExamen = [];

        self::abrirConex();

        $consulta = "SELECT * FROM preguntas WHERE idExamen=?";
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $idPregunta = $row['idPregunta'];
                $idExamen = $row['idExamen'];
                $descripcion = $row['pregunta'];
                $consulta2 = 'SELECT * FROM respuestasCorrectas WHERE idPregunta=?';
                $stmt2 = self::$conexion->prepare($consulta2);
                $stmt2->bind_param('i', $val2);
                $val2 = $idPregunta;
                $stmt2->execute();
                if ($resultado2 = $stmt2->get_result()) {
                    while ($row = $resultado2->fetch_assoc()) {
                        $tipo = $row['tipo'];
                    }
                }
                $pregunta = new PreguntaAux($idPregunta, $idExamen, $descripcion, $tipo);
                $preguntasExamen[] = $pregunta;
            }
        }

        self::cerrarConex();
        return $preguntasExamen;
    }

    public static function getRespuestas($id2) {

        self::abrirConex();

        $consulta = 'SELECT * FROM respuestasCorrectas WHERE idPregunta=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id2;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = new Pregunta($row['idPregunta'], $row['tipo'], $row['respuesta1'], $row['respuesta2'], $row['respuesta3'], $row['respuesta4'], $row['respuestaCorrecta']);
            }
        }

        self::cerrarConex();
        return $r;
    }

    public static function getNotas($dni) {

        self::abrirConex();

        $notas = [];

        $consulta = 'SELECT * FROM examenAlumno WHERE id_Alumno=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $dni;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = new examenAlumno($row['id_Examen'], $row['id_Alumno'], $row['nota']);
                $notas[] = $r;
            }
        }

        self::cerrarConex();
        return $notas;
    }

    public static function getNotasProfesor($id) {

        self::abrirConex();

        $notas = [];

        $consulta = 'SELECT * FROM examenAlumno WHERE id_Examen=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('s', $val1);
        $val1 = $id;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = new examenAlumno($row['id_Examen'], $row['id_Alumno'], $row['nota']);
                $notas[] = $r;
            }
        }

        self::cerrarConex();
        return $notas;
    }

    public static function addRespuesta($id_Examen, $id_Alumno, $id_Pregunta, $respuesta) {
        self::abrirConex();

        $consulta = 'INSERT INTO respuestasAlumnos VALUES (?,?,?,?)';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('isis', $val1, $val2, $val3, $val4);
        $val1 = $id_Examen;
        $val2 = $id_Alumno;
        $val3 = $id_Pregunta;
        $val4 = $respuesta;
        $stmt->execute();



        self::cerrarConex();
    }

    public static function isExamen($id_Examen, $id_Alumno) {

        self::abrirConex();
        $r = false;

        $consulta = 'SELECT * FROM respuestasAlumnos WHERE id_Examen=? AND id_Alumno=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('is', $val1, $val2);
        $val1 = $id_Examen;
        $val2 = $id_Alumno;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = true;
            }
        }

        self::cerrarConex();
        return r;
    }

    public static function deleteRespuestas($id_Examen, $id_Alumno) {

        self::abrirConex();

        $consulta = 'DELETE FROM respuestasAlumnos WHERE id_Examen=? AND id_Alumno=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('is', $val1, $val2);
        $val1 = $id_Examen;
        $val2 = $id_Alumno;
        $stmt->execute();

        self::cerrarConex();
    }

    public static function getDNI($id) {

        self::abrirConex();

        $r = [];

        $consulta = 'SELECT DISTINCT id_Alumno from respuestasAlumnos WHERE id_Examen=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r[] = $row['id_Alumno'];
            }
        }

        self::cerrarConex();
        return $r;
    }

    public static function getRespuestasAlumno($dni, $id) {

        self::abrirConex();

        $r = [];

        $consulta = 'SELECT * FROM respuestasAlumnos WHERE id_Alumno=? AND id_Examen=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('si', $val1, $val2);
        $val1 = $dni;
        $val2 = $id;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $aux = new RespuestasAlumno($row['id_Examen'], $row['id_Alumno'], $row['id_Pregunta'], $row['respuesta']);
                $r[] = $aux;
            }
        }

        self::cerrarConex();
        return $r;
    }

    public static function getCorrecta($id) {

        self::abrirConex();

        $consulta = 'SELECT respuestaCorrecta FROM respuestasCorrectas WHERE idPregunta=?';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('i', $val1);
        $val1 = $id;
        $stmt->execute();
        if ($resultado = $stmt->get_result()) {
            while ($row = $resultado->fetch_assoc()) {
                $r = $row['respuestaCorrecta'];
            }
        }

        self::cerrarConex();
        return $r;
    }

    public static function setNota($id_Examen, $id_Alumno, $nota) {

        self::abrirConex();

        $consulta = 'INSERT INTO examenAlumno VALUE (?,?,?)';
        $stmt = self::$conexion->prepare($consulta);
        $stmt->bind_param('iss', $val1, $val2, $val3);
        $val1 = $id_Examen;
        $val2 = $id_Alumno;
        $val3 = $nota;
        $stmt->execute();

        self::cerrarConex();
    }

}
