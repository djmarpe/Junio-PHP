<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Preferencia
 *
 * @author alejandro
 */
class Preferencia {
    private $id;
    private $idUsuario;
    private $type;
    private $value;

    function __construct() {
    }
    
    function getId() {
        return $this->id;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getType() {
        return $this->type;
    }


    function getValue() {
        return $this->value;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    function setType($type): void {
        $this->type = $type;
    }

    function setValue($value): void {
        $this->value = $value;
    }

}
