<?php
namespace App\LDAP\controller;

use App\LDAP\controller\AbstractController;
use App\LDAP\controller\ControllerSQL;
use App\LDAP\controller\ControllerDefault;
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
        
        if (!$ldap_conn) {
            echo "Connexion échouée";
            return;
        }
        
        /*  echo "Ldap Search Filter : " . $ldap_searchfilter */; 
        $search = ldap_search($ldap_conn, $ldap_baseDn, $ldap_searchfilter);
        if (!$search) {
            echo "Ldap search didn't succeed";
            return;
        }
        
        $user_result = ldap_get_entries($ldap_conn, $search); 
         /* echo "Ldap Search User Count : ";
        print_r($user_result["count"]); */

        if ($user_result["count"] > 0) {
            $dn = "cn=".$ldap_login.",".$ldap_baseDn;
            if (ldap_bind($ldap_conn, $dn, $ldap_password)) {
                print_r( $_SESSION['user_logged_in']); 
                print_r( $_SESSION['username'] = $ldap_login); 
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $ldap_login;
                ControllerDefault::homepage($ldap_login);
            } else {
                self::afficheVue("authentification.php", ["error"=>ldap_error($ldap_conn)]);
            }
        } else {
            echo "Utilisateur non trouvé.";
        }
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
        $search = ldap_search($ldap_conn, Conf::$ldap_basedn, "(objectClass=inetOrgPerson)");
        $resultats = ldap_get_entries($ldap_conn, $search);
    
        $users = [];
    
        for ($i = 0; $i < $resultats['count']; $i++) {
            $user = [];
    
            // Récupération du nom complet (Common Name - 'cn')
            $user['cn'] = isset($resultats[$i]['cn'][0]) ? $resultats[$i]['cn'][0] : null;
    
            // Récupération de l'adresse e-mail
            $user['mail'] = isset($resultats[$i]['mail'][0]) ? $resultats[$i]['mail'][0] : null;
    
            $users[] = $user;
        }
    
        return $users;
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