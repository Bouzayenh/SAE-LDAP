<?php
namespace App\LDAP\controller;

use App\LDAP\controller\AbstractController;
use App\LDAP\controller\ControllerSQL;
use App\LDAP\config\ConfLocal as Conf;

use App\LDAP\model\Repository\LDAPConnexion;

class ControllerLDAP extends AbstractController{

    public static function checkUser() {
        $ldap_login = $_GET["user"];
        $ldap_password = $_GET["pass"];
        $ldap_conn = LDAPConnexion::getInstance();
        $ldap_baseDn= LDAPConnexion::getBaseDn();
        $ldap_searchfilter = "(objectClass=inetOrgPerson)";
        echo "Base Dn : " . $ldap_baseDn . " \n ";
        if(!$ldap_conn){
            echo "Connexion echué";
        }
        echo "Ldap Search Filter : " . $ldap_searchfilter;
        $search = ldap_search($ldap_conn, $ldap_baseDn, $ldap_searchfilter);
        if(!$search){
            echo "Ldap search didn't succeed";
        }
        $user_result = ldap_get_entries($ldap_conn, $search);
        // on verifie que l’entree existe bien
        $user_exist = $user_result["count"] > 0;
        print_r($user_result);
        echo "Ldap Search User Count : ";
        print_r($user_result["count"]);
        // si l’utilisateur existe bien,
        
        $passwd_ok = 1;

        if($user_exist) {
        $dn = "cn=".$ldap_login.",".$ldap_baseDn;
        echo "Dn if user exists = " . $dn;
        $passwd_ok = ldap_bind(LDAPConnexion::getInstance(), $dn, $ldap_password);
        }

        return $passwd_ok;
    }

    public static function createNewUser() {
        $ldap_conn = LDAPConnexion::getInstance();
        if (!$ldap_conn) { 
            echo "La connexion semble ne pas avoir été établie";
            return false;
         }
        
        $newUserDn = 'cn='. $_GET["nom"] .',ou=Users,' . LDAPConnexion::getBaseDn();
        $newUserData = [
            'cn' => $_GET["nom"],
            'sn' => $_GET["prenom"],
            'uid' => $_GET["user"],
            'mail' => $_GET["mail"],
            'userPassword'=>$_GET["pass"],
            'objectclass' => ['inetOrgPerson'],
        ];
        
        // Add data to directory
        $addResult = ldap_add($ldap_conn, $newUserDn, $newUserData);
        if (!$addResult){
            echo "Failed to add new user " . ldap_error($ldap_conn);
        }

        ControllerSQL::insertOrUpdateUserInDatabase($newUserData);
    
        return true;
    }
    
    public static function listUsers() {
        $ldap_conn = LDAPConnexion::getInstance();
        //On recherche toutes les entres du LDAP qui sont des personnes
        $search = ldap_search($ldap_conn, Conf::$ldap_basedn, "(objectClass=person)");
        //On recupere toutes les entres de la recherche effectuees auparavant
        $resultats = ldap_get_entries($ldap_conn, $search);
        //Pour chaque utilisateur, on recupere les informations utiles
        for ($i=0; $i < count($resultats) - 1 ; $i++) {
        //On stocke le login, nom/prnom, la classe et la promotion de l’utilisateur courant
        $nomprenom = explode(" ", $resultats[$i]['displayname'][0]);
        $promotion = explode("=", explode(",", $resultats[$i]['dn'])[1])[1];
        }
    }


    public static function fetchUsersFromLDAP() {
        $ldap_conn = LDAPConnexion::getInstance();
        $ldap_baseDn = LDAPConnexion::getBaseDn();
        $ldap_searchfilter = "(objectClass=inetOrgPerson)";
    
        $search = ldap_search($ldap_conn, 'ou=Users,' . $ldap_baseDn, $ldap_searchfilter);
        if (!$search) {
            echo "Ldap search didn't succeed";
            return [];
        }
    
        $users = ldap_get_entries($ldap_conn, $search);
        return $users;
    }

    
    public static function disconnect(){
        ldap_close(Conf::$ldap_conn);
    }
}

?>