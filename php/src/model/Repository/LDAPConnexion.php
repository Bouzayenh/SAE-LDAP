<?php
namespace App\LDAP\Model\Repository;

use App\LDAP\config\Conf;
use App\LDAP\config\LocalConf;

class LDAPConnexion {
    private static $ldapConnexion = null;
    public static bool $local = false;

    private function __construct() {
        $ldap_host = self::$local ? LocalConf::$ldap_host : Conf::$ldap_host;
        $ldap_port = self::$local ? LocalConf::$ldap_port : Conf::$ldap_port;

        $ldap_conn = ldap_connect($ldap_host, $ldap_port);
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        self::$ldapConnexion = $ldap_conn;
    }

    public static function getInstance() {
        if (is_null(self::$ldapConnexion)) {
            new self();
        }
        return self::$ldapConnexion;
    }

    public static function toggleLocal(){
        self::$ldapConnexion = null;
        self::$local = true;
    }
    public static function toogleIUT(){
        self::$ldapConnexion = null;
        self::$local = false;
    }



}