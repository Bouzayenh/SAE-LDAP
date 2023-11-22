<?php
namespace App\LDAP\controller;

use App\LDAP\config\Conf;
use App\LDAP\controller\AbstractController;
use App\LDAP\model\Repository\LDAPConnexion;

class ControllerLDAP extends AbstractController{

    public static function choixRepertoire(){
        $repertoire_choisie = $_GET["dirOptions"];    
        if(strcmp($repertoire_choisie,"Local") == 0){
            LDAPConnexion::toggleLocal();
            echo "Toggled Local";
        }
        self::afficheVue("authentification.php",["Pagetitle"=>"Authentification","directory"=>$repertoire_choisie]);
    }

    public static function checkUser() {
        $ldap_login = $_GET["user"];
        $ldap_password = $_GET["pass"];
        $ldap_searchfilter = "(cn=$ldap_login)";
        $ldap_conn = LDAPConnexion::getInstance();
        $ldap_baseDn= LDAPConnexion::getBaseDn();
        echo $ldap_baseDn;
        var_dump($ldap_conn);
        $search = ldap_search($ldap_conn, $ldap_baseDn, $ldap_searchfilter, array());
        $user_result = ldap_get_entries($ldap_conn, $search);
        // on verifie que l’entree existe bien
        $user_exist = $user_result["count"] == 1;
        // si l’utilisateur existe bien,
        if($user_exist) {
        $dn = "cn=".$ldap_login.$ldap_baseDn;
        $passwd_ok = ldap_bind(LDAPConnexion::getInstance(), $dn, $ldap_password);
        }

        return $passwd_ok;
    }

    public static function createNewUser($ldapconn, $username, $password) {
        if (!$ldapconn) { return false; }
        $r = ldap_bind($ldapconn, "cn=admin,dc=test,dc=com", "12345X");
    
        // Prepare data

        $info["cn"]="John Jones";
        $info["sn"]="Jones";
        $info["mail"]="jonj@example.com";
        $info["objectclass"]="person";
    
        // Add data to directory
        $r = ldap_add($ldapconn, "cn=John Jones,dc=test,dc=com", $info);
    
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
    
    public static function disconnect(){
        ldap_close(Conf::$ldap_conn);
    }
}

?>