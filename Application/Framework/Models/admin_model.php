<?php

class Admin_model extends APP_Model{

    public function __construct()
    {
       $this->Load->database();
    }

    public function login($username, $password)
    {
        $login  = $this->Database->MongoFind("users", ["username" => $username, "password" => $password], "", "", true);
        //print_r($login);
        if($login){
            return true;
        } else {
            return false;
        }
    }



}