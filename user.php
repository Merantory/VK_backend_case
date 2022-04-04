<?php

class user {

    private $id;
    private $token;
    private $username;
    private $is_anonym = false;

    public function __construct($token,$username){
        $this->token = $token;
        $this->username = $username;
        if ($token === NULL || $username === NULL) $this->is_anonym = true;
    }

    public function isAnonym() {
        return $this->is_anonym;
    }

    public function setID($id) {
        $this->id = $id;
    }

    public function getID() {
        return $this->id;
    }

    public function getToken() {
        return $this->token;
    }

    public function getUsername() {
        if ($this->is_anonym) return 'Анонимно';
        else return $this->username;
    }
}