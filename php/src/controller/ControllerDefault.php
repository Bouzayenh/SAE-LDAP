<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification(){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification"]);
        
    }

    public static function homepage($user = NULL){
        self::afficheVue("view.php", ["Pagetitle" => "Accueil de l'application", "cheminVueBody"=>"homePage.php", "user"=>$user]);
    }

    public static function user(){
        self::afficheVue("view.php", ["Pagetitle" => "Profil Utilisateur","cheminVueBody"=>"user.php"]);
    }    

    public static function test(){
        self::afficheVue("view.php",["Pagetitle"=>"Test","cheminVueBody"=>"testconn.php"]);
    }

    public static function createNewUser(){
        self::afficheVue("view.php",["Pagetitle"=>"Ajouter un Utilisateur","cheminVueBody"=>"createUser.php"]);
    }

    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}