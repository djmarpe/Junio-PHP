<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 * @author alejandro
 */
class Persona {

    private $id;
    private $name;
    private $surname;
    private $email;
    private $passwd;
    private $fecNac;
    private $country;
    private $city;
    private $sex;
    private $description;
    private $status;
    private $rol;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getEmail() {
        return $this->email;
    }

    function getPasswd() {
        return $this->passwd;
    }

    function getFecNac() {
        return $this->fecNac;
    }

    function getCountry() {
        return $this->country;
    }

    function getCity() {
        return $this->city;
    }

    function getSex() {
        return $this->sex;
    }

    function getDescription() {
        return $this->description;
    }

    function getStatus() {
        return $this->status;
    }

    function getRol() {
        return $this->rol;
    }

        function setId($id): void {
        $this->id = $id;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setSurname($surname): void {
        $this->surname = $surname;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPasswd($passwd): void {
        $this->passwd = $passwd;
    }

    function setFecNac($fecNac): void {
        $this->fecNac = $fecNac;
    }

    function setCountry($country): void {
        $this->country = $country;
    }

    function setCity($city): void {
        $this->city = $city;
    }

    function setSex($sex): void {
        $this->sex = $sex;
    }

    function setDescription($description): void {
        $this->description = $description;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setRol($rol): void {
        $this->rol = $rol;
    }
}
