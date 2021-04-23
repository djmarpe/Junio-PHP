<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mensaje
 *
 * @author alejandro
 */
class Mensaje {
    private $id;
    private $idUsuarioEmisor;
    private $emailUsuarioEmisor;
    private $idUsuarioReceptor;
    private $emailUsuarioReceptor;
    private $asunto;
    private $cuerpo;
    private $leido;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getIdUsuarioEmisor() {
        return $this->idUsuarioEmisor;
    }

    function getIdUsuarioReceptor() {
        return $this->idUsuarioReceptor;
    }

    function getAsunto() {
        return $this->asunto;
    }

    function getCuerpo() {
        return $this->cuerpo;
    }

    function getLeido() {
        return $this->leido;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setIdUsuarioEmisor($idUsuarioEmisor): void {
        $this->idUsuarioEmisor = $idUsuarioEmisor;
    }

    function setIdUsuarioReceptor($idUsuarioReceptor): void {
        $this->idUsuarioReceptor = $idUsuarioReceptor;
    }

    function setAsunto($asunto): void {
        $this->asunto = $asunto;
    }

    function setCuerpo($cuerpo): void {
        $this->cuerpo = $cuerpo;
    }

    function setLeido($leido): void {
        $this->leido = $leido;
    }

    function getEmailUsuarioEmisor() {
        return $this->emailUsuarioEmisor;
    }

    function getEmailUsuarioReceptor() {
        return $this->emailUsuarioReceptor;
    }

    function setEmailUsuarioEmisor($emailUsuarioEmisor): void {
        $this->emailUsuarioEmisor = $emailUsuarioEmisor;
    }

    function setEmailUsuarioReceptor($emailUsuarioReceptor): void {
        $this->emailUsuarioReceptor = $emailUsuarioReceptor;
    }

}
