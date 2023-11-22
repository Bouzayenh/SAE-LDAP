<?php
use App\LDAP\model\Repository\LDAPConnexion;

$ldapConn = LDAPConnexion::getInstance();
if ($ldapConn) {
    echo "LDAP Connection successful.";
    echo $ldapConn;
} else {
    echo "Failed to connect to LDAP server.";
}

// Optionally, test fetching the base DN
echo "Base DN: " . LDAPConnexion::getBaseDn();
?>
