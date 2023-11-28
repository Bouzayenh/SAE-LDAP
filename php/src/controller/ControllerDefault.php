<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification($errormessage = NULL){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","errormessage"=>$errormessage]);
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

    public static function createNewUser($errormessage = NULL){
        self::afficheVue("view.php",["Pagetitle"=>"Creer un Utilisateur","cheminVueBody"=>"createUser.php","errormessage"=>$errormessage]);
    }

    public static function listAllUsers(){
        self::afficheVue("view.php", ["Pagetitle" => "Liste des Utilisateurs", "cheminVueBody" => "userList.php"]);
    }

    public static function checkUser(){
        self::afficheVue("view.php", ["Pagetitle" => "Authentification", "cheminVueBody" => "authentification.php"]);
    }
    
    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}