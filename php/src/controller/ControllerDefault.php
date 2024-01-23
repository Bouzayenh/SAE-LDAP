<?php
namespace App\LDAP\controller;

use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{

    public static function authentification($errormessage = NULL){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","errormessage"=>$errormessage]);
    }

    public static function homepage($message = NULL){
        self::afficheVue("view.php", ["Pagetitle" => "Accueil de l'application", "cheminVueBody"=>"homePage.php", "message"=>$message]);
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
    public static function modifyUser($errormessage = NULL, $message = NULL){
        $user = $_GET['user'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $mail = $_GET['mail'];
        $dn = $_GET['dn'];
        self::afficheVue("view.php",["Pagetitle"=>"Modifier Utilisateur","cheminVueBody"=>"modifyUser.php", "user"=>$user,"nom"=>$nom, "prenom"=>$prenom, "mail"=>$mail,"errormessage"=>$errormessage, "message"=>$message,"dn"=>$dn]);
    }

    public static function listAllUsers($errormessage = NULL, $message = NULL){
        self::afficheVue("view.php", ["Pagetitle" => "Liste des Utilisateurs", "cheminVueBody" => "userList.php", "message"=>$message,"errormessage"=>$errormessage]);
    }

    public static function checkUser(){
        self::afficheVue("view.php", ["Pagetitle" => "Authentification", "cheminVueBody" => "authentification.php"]);
    }
    
    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}
