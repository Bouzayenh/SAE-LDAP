<?php
namespace App\LDAP\model\Repository;

use App\LDAP\config\ConfLocal;

class LDAPConnexion {
    private static $ldapConnexion = null;

    private static function connect() {
        $ldap_host = ConfLocal::$ldap_host;
        $ldap_port = ConfLocal::$ldap_port;
        
        $ldap_conn = ldap_connect($ldap_host, $ldap_port);
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldapbind = ldap_bind($ldap_conn,getenv('LDAP_ADMIN_CN'),getenv('LDAP_ADMIN_PASSWORD'));
        if(!$ldapbind){
            echo "Pas de ldap bind";
        }
        return $ldap_conn;
    }

    public static function getInstance() {
        if (is_null(self::$ldapConnexion)) {
            self::$ldapConnexion = self::connect();
        }
        return self::$ldapConnexion;
    }

    public static function getBaseDn(){
        return ConfLocal::$ldap_basedn;
    }

}