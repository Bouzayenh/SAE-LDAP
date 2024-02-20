<?php
namespace App\LDAP\model\Repository;

use App\LDAP\config\ConfLocal;

class LDAPConnexion {
    private static $ldapConnexion = null;
    private static $ldap_cn = null;
    private static $ldap_pass = null;

    private static function getSecrets(){
        $cnSecret = fopen("/run/secrets/ldap_admin_cn", 'r');
        self::$ldap_cn = fgets($cnSecret);
        fclose($cnSecret);

        $passSecret = fopen("/run/secrets/ldap_admin_password", "r");
        self::$ldap_pass = fgets($passSecret);
        fclose($passSecret);
    }
    private static function getEnv(){
        self::$ldap_cn = getenv('ldap_admin_cn');
        self::$ldap_pass = getenv('ldap_admin_password');
    }

    private static function connect() {
        $ldap_host = ConfLocal::$ldap_host;
        $ldap_port = ConfLocal::$ldap_port;
        
        $ldap_conn = ldap_connect($ldap_host, $ldap_port);
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        self::getSecrets();
    
        $ldapbind = ldap_bind($ldap_conn,self::$ldap_cn,self::$ldap_pass);
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