<?php
namespace App\LDAP\controller;

use App\LDAP\controller\AbstractController;

if(!isset($_SESSION)){
    session_start();
}

class ControllerDefault extends AbstractController{


    private static function setSessionMessage($errormessage, $message){
        $_SESSION['error_message'] = $errormessage;
        $_SESSION['message'] = $message;
    }
    public static function authentification($errormessage = NULL){
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","errormessage"=>$errormessage]);
    }

    public static function homepage($error_message = NULL, $message = NULL){
        self::setSessionMessage($error_message, $message);
        self::afficheVue("view.php", ["Pagetitle" => "Accueil de l'application", "cheminVueBody"=>"homePage.php"]);
    }

    public static function user(){
        self::afficheVue("view.php", ["Pagetitle" => "Profil Utilisateur","cheminVueBody"=>"user.php"]);
    }    

    public static function createNewUser($errormessage = NULL, $message=NULL){
        self::setSessionMessage($errormessage, $message);
        self::afficheVue("view.php",["Pagetitle"=>"Creer un Utilisateur","cheminVueBody"=>"createUser.php","errormessage"=>$errormessage]);
    }
    public static function modifyUser($errormessage = NULL, $message = NULL){
        self::setSessionMessage($errormessage, $message);
        $user = $_GET['user'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $mail = $_GET['mail'];
        $dn = $_GET['dn'];
        self::afficheVue("view.php",["Pagetitle"=>"Modifier Utilisateur","cheminVueBody"=>"modifyUser.php", "user"=>$user,"nom"=>$nom, "prenom"=>$prenom, "mail"=>$mail,"dn"=>$dn]);
    }

    public static function listAllUsers($errormessage = NULL, $message = NULL){
        self::setSessionMessage($errormessage, $message);
        self::afficheVue("view.php", ["Pagetitle" => "Liste des Utilisateurs", "cheminVueBody" => "userList.php"]);
    }

    public static function checkUser(){
        
        self::afficheVue("view.php", ["Pagetitle" => "Authentification", "cheminVueBody" => "authentification.php"]);
    }
    
    public static function notFound(){
        self::afficheVue("NotFound.php");
    }

}
