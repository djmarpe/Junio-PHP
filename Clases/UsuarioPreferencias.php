<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioPreferencias
 *
 * @author alejandro
 */
class UsuarioPreferencias {
    private $idUsuario;
    private $nombreUsuario;
    private $apellidosUsuario;
    private $fechaNacimientoUsuario;
    private $descripcion;
    private $email;
    private $pais;
    private $localidad;
    private $sexo;
    private $preferencias;
    
    function __construct() {
        $this->preferencias = [];
    }
    
    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    function getApellidosUsuario() {
        return $this->apellidosUsuario;
    }

    function getFechaNacimientoUsuario() {
        return $this->fechaNacimientoUsuario;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getEmail() {
        return $this->email;
    }

    function getPais() {
        return $this->pais;
    }

    function getLocalidad() {
        return $this->localidad;
    }

    function getSexo() {
        return $this->sexo;
    }

    function setIdUsuario($idUsuario): void {
        $this->idUsuario = $idUsuario;
    }

    function setNombreUsuario($nombreUsuario): void {
        $this->nombreUsuario = $nombreUsuario;
    }

    function setApellidosUsuario($apellidosUsuario): void {
        $this->apellidosUsuario = $apellidosUsuario;
    }

    function setFechaNacimientoUsuario($fechaNacimientoUsuario): void {
        $this->fechaNacimientoUsuario = $fechaNacimientoUsuario;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPais($pais): void {
        $this->pais = $pais;
    }

    function setLocalidad($localidad): void {
        $this->localidad = $localidad;
    }

    function setSexo($sexo): void {
        $this->sexo = $sexo;
    }
    
    function getPreferencias() {
        return $this->preferencias;
    }

    function addPreferencias($preferencias): void {
        $this->preferencias[] = $preferencias;
    }
    
    function setPreferencias($preferencias): void {
        $this->preferencias = $preferencias;
    }



}
