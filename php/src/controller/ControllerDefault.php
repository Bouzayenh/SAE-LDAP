<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification(){
        self::afficheVue("header.php",["Pagetitle"=>"Authentification","cheminVueBody"=>"authentification.php"]);
        
    }

    public static function homepage(){
        self::afficheVue("header.php", ["Pagetitle" => "Accueil de l'application", "cheminVueBody"=>"homePage.php"]);
    }

    public static function user(){
        self::afficheVue("header.php", ["Pagetitle" => "Profil Utilisateur","cheminVueBody"=>"user.php"]);
    }    

    public static function test(){
        self::afficheVue("header.php",["Pagetitle"=>"Test","cheminVueBody"=>"testconn.php"]);
    }

    public static function createNewUser(){
        self::afficheVue("header.php",["Pagetitle"=>"Ajouter un Utilisateur","cheminVueBody"=>"createUser.php"]);
    }

    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}