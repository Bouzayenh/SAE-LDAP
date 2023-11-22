<?php

namespace App\LDAP\config;


class LocalConf {
    // on definit les parametres de la connexion LDAP
    public static $ldap_host = "openldap";
    public static $ldap_basedn = "dc=testdomaine,dc=com";
    public static $ldap_port = 389;
    public static $ldap_conn = false;
}

?>
