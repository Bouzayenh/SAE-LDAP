<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification(){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","directory"=>"Local"]);
    }

    public static function test(){
        self::afficheVue("testconn.php",["Pagetitle"=>"Test","directory"=>"Local"]);
    }

    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}