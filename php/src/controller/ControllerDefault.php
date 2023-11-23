<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification(){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","directory"=>"Local"]);
    }

    public static function homepage(){
        self::afficheVue("homepage.php", ["Pagetitle" => "Accueil de l'application"]);
    }

    public static function user(){
        self::afficheVue("user.php", ["Pagetitle" => "Profil Utilisateur"]);
    }

    public static function includeHeader(){
        include(__DIR__.'/../view/header.php');
    }
    

    public static function test(){
        self::afficheVue("testconn.php",["Pagetitle"=>"Test","directory"=>"Local"]);
    }

    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}