<?php

namespace App\LDAP\controller;

if(!session_id())
session_start();

use App\LDAP\controller\AbstractController;
use App\LDAP\controller\ControllerSQL;
use App\LDAP\controller\ControllerDefault;
use App\LDAP\config\ConfLocal as Conf;

use App\LDAP\model\Repository\LDAPConnexion;

class ControllerLDAP extends AbstractController{

    public static function checkUser() {
        $ldap_login = $_POST["user"];
        $ldap_password = $_POST["pass"];
        $ldap_conn = LDAPConnexion::getInstance();
        $ldap_baseDn= LDAPConnexion::getBaseDn();
        $ldap_searchfilter = "(objectClass=inetOrgPerson)";
        
        if (!$ldap_conn) {
            ControllerDefault::authentification("Connexion failed");
        }

        /*  echo "Ldap Search Filter : " . $ldap_searchfilter */; 
        $search = ldap_search($ldap_conn, $ldap_baseDn, $ldap_searchfilter);
        if (!$search) {
            ControllerDefault::authentification("Ldap Search didn't succeed");
        }
        
        $user_result = ldap_get_entries($ldap_conn, $search); 
        
        /* echo "Ldap Search User Count : ";
        print_r($user_result["count"]); */

        if ($user_result["count"] > 0) {
            $dn = "cn=".$ldap_login.",".$ldap_baseDn;
            if (ldap_bind($ldap_conn, $dn, $ldap_password)) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['username'] = $ldap_login;
                if (!isset($_SESSION['user_logged_in'])){
                    echo 'Session true with isset and !';
                }
                ControllerDefault::homepage();
            } else {
                ControllerDefault::authentification(ldap_error($ldap_conn));
            }
        } else {
            ControllerDefault::authentification("Utilisateur non trouvé");
        }
    }

    public static function createNewUser() {
        $ldap_conn = LDAPConnexion::getInstance();
        if (!$ldap_conn) { 
            echo "La connexion semble ne pas avoir été établie";
            return false;
         }
        
        $newUserDn = 'cn='. $_POST["nom"] .',ou=Users,' . LDAPConnexion::getBaseDn();
        $newUserData = [
            'cn' => $_POST["nom"],
            'sn' => $_POST["prenom"],
            'uid' => $_POST["user"],
            'mail' => $_POST["mail"],
            'userPassword'=>$_POST["pass"],
            'objectclass' => ['inetOrgPerson'],
        ];
        
        // Add data to directory
        $addResult = ldap_add($ldap_conn, $newUserDn, $newUserData);
        if (!$addResult){
            ControllerDefault::createNewUser("Failed to add new user " . ldap_error($ldap_conn));
        }else {
            // ajoute user to Clients group
            $clientsGroupDn = 'cn=Clients,ou=Groups,' . LDAPConnexion::getBaseDn();
            $addMember = [
                'member' => $newUserDn
            ];
            $modifyResult = ldap_mod_add($ldap_conn, $clientsGroupDn, $addMember);
            
            if (!$modifyResult) {
                ControllerDefault::createNewUser("Failed to add user to Clients group " . ldap_error($ldap_conn));
                return false;
            }
            ControllerSQL::insertOrUpdateUserInDatabase($newUserData);
            ControllerDefault::homepage("L'utilisateur à bien été ajouté");
            return true;
        }
    }

    public static function modifyUser(){

        $userDn = $_POST['dn'];
        
        $ldap_conn = LDAPConnexion::getInstance();

        $userModifiedData = [];
        if(isset($_POST['nom'])){
            $userModifiedData['cn']= $_POST['nom'];
        }
        if(isset($_POST['prenom'])){
            $userModifiedData['sn'] = $_POST['prenom'];
        }
        if(isset($_POST['user'])){
            $userModifiedData['uid'] = $_POST['user']; 
        }
        if(isset($_POST['mail'])){
            $userModifiedData['mail'] = $_POST['mail'];
        }

        $return_value = ldap_modify($ldap_conn, $userDn, $userModifiedData);
        
    
        if($return_value == true){
            
            ControllerDefault::listAllUsers(NULL, " L'utilisateur à bien été modifié ");
            ControllerSQL::insertOrUpdateUserInDatabase($userModifiedData); 
        }
        else{
            ControllerDefault::listAllUsers("Il semble avoir un erreur lors de la modification : " . ldap_error($ldap_conn));
        }
        echo "Return value : ";
        var_dump($return_value);
    }
    public static function deleteUser(){
        $userDn = $_GET['dn'];
        $ldap_conn = LDAPConnexion::getInstance();

        $return_value = ldap_delete($ldap_conn,$userDn);

        if($return_value){
            ControllerDefault::listAllUsers(NULL,"L'utilisateur à bien été éliminé");
        }
        else{
            ControllerDefault::listAllUsers("Il semble que l'utilisateur n'a pas pu être éliminé".ldap_error($ldap_conn));
        }

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
            
            $user['dn'] = isset($resultats[$i]['dn']) ? $resultats[$i]['dn'] : null;

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