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
        
        if (!$ldap_conn) {
            ControllerDefault::autentification("Connexion failed");
        }

        /*  echo "Ldap Search Filter : " . $ldap_searchfilter */; 
        $search = ldap_search($ldap_conn, $ldap_baseDn, $ldap_searchfilter);
        if (!$search) {
            ControllerDefault::autentification("Ldap Search didn't succeed");
        }
        
        $user_result = ldap_get_entries($ldap_conn, $search); 
        
        /* echo "Ldap Search User Count : ";
        print_r($user_result["count"]); */

        if ($user_result["count"] > 0) {
            $dn = "cn=".$ldap_login.",".$ldap_baseDn;
            if (ldap_bind($ldap_conn, $dn, $ldap_password)) {
                session_start();
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $ldap_login;
                if (!isset($_SESSION['user_logged_in'])){
                    echo 'Session true with isset and !';
                }
                ControllerDefault::homepage($ldap_login);
            } else {
                ControllerDefault::authentification(ldap_error($ldap_conn));
            }
        } else {
            ControllerDefault::autentification("Utilisateur non trouvé");
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
            ControllerDefault::createNewUser("Failed to add new user " . ldap_error($ldap_conn));
        }

        ControllerSQL::insertOrUpdateUserInDatabase($newUserData);
        ControllerDefault::homepage($_SESSION['username'],"L'utilisateur à bien été ajouté");
        return true;
    }
    public static function modifyUser(){

        if(isset($_SESSION['user_logged_in'])){ echo 'Session working in pinpoint';}
        else{ echo "Session not working in pinpoint";}

        $userDn = 'cn='. $_GET["vieux_nom"] .',ou=Users,' . LDAPConnexion::getBaseDn();
        
        $ldap_conn = LDAPConnexion::getInstance();

        $userModifiedData = [];
        if(isset($_GET['nom'])){
            $userModifiedData['cn']= $_GET['nom'];
        }
        if(isset($_GET['prenom'])){
            $userModifiedData['sn'] = $_GET['prenom'];
        }
        if(isset($_GET['user'])){
            $userModifiedData['uid'] = $_GET['user']; 
        }
        if(isset($_GET['mail'])){
            $userModifiedData['mail'] = $_GET['mail'];
        }
        
        $return_value = ldap_modify($ldap_conn,$userDn, $userModifiedData);
        
        $username = NULL;
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
        }
        
        if($return_value){
            ControllerDefault::homepage($username, " L'utilisateur à bien été modifié ");
        }
        else{
            ControllerDefault::modifyUser("Il semble avoir un erreur lors de la modification : " . ldap_error($ldap_conn));
        }

        var_dump($return_value);
        ControllerSQL::insertOrUpdateUserInDatabase($userModifiedData); 
    }
    
    public static function listUsers() {
        $ldap_conn = LDAPConnexion::getInstance();
        $attributes = array("cn", "sn", "mail", "uid");
        $search = ldap_search($ldap_conn,LDAPConnexion::getBaseDn(), "(objectClass=inetOrgPerson)", $attributes);
        $resultats = ldap_get_entries($ldap_conn, $search);
    
        $users = [];
    
        for ($i = 0; $i < $resultats['count']; $i++) {
            $user = [];
        
            //Récuperation de l'utilisateur
            $user['uid'] = isset($resultats[$i]['uid'][0]) ? $resultats[$i]['uid'][0] : null;

            // Récupération du nom complet (Common Name - 'cn')
            $user['cn'] = isset($resultats[$i]['cn'][0]) ? $resultats[$i]['cn'][0] : null;
    
            // Réuperation du Prènom (Sur Name - 'sn')
            $user['sn'] = isset($resultats[$i]['sn'][0]) ? $resultats[$i]['sn'][0] : null;

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