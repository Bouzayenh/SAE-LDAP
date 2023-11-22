<?php

namespace App\LDAP\config;


class Conf {
    // on definit les parametres de la connexion LDAP
    public static $ldap_host = "10.10.1.30";
    public static $ldap_basedn = "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
    public static $ldap_port = 389;
    public static $ldap_conn = false;
}

?>