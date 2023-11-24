<?php
namespace App\LDAP\controller;

use App\LDAP\model\Repository\SQLConnexion;
use App\LDAP\controller\AbstractController;
use App\LDAP\controller\ControllerLDAP;



class ControllerSQL extends AbstractController{

    public static function initDatabaseWithLDAPUsers() {
        $users = ControllerLDAP::fetchUsersFromLDAP();

        foreach ($users as $user) {
            # Check if the user has the required attributes and not null
            if (isset($user['cn']) && is_array($user['cn']) && isset($user['sn']) && is_array($user['sn']) && isset($user['uid']) && is_array($user['uid']) && isset($user['mail']) && is_array($user['mail'])) {
                self::insertOrUpdateUserInDatabase($user);
            }

        }
        
    }


    public static function insertOrUpdateUserInDatabase($user) {
        $conn = SQLConnexion::getInstance();
    
        // Initialize default values
        $userd = array(
            "nom" => null,
            "prenom" => null,
            "username" => null,
            "mail" => null
        );
    
        // Check if the keys exist and are arrays before accessing their elements
        if (isset($user['cn']) && is_array($user['cn'])) {
            $userd['nom'] = $user['cn'][0];
        }
        if (isset($user['sn']) && is_array($user['sn'])) {
            $userd['prenom'] = $user['sn'][0];
        }
        if (isset($user['uid']) && is_array($user['uid'])) {
            $userd['username'] = $user['uid'][0];
        }
        if (isset($user['mail']) && is_array($user['mail'])) {
            $userd['mail'] = $user['mail'][0];
        }
    
        $stmt = $conn->prepare("INSERT INTO users (nom, prenom, username, mail) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE nom=VALUES(nom), prenom=VALUES(prenom), mail=VALUES(mail)");
        $stmt->bindValue(1, $userd['nom']);
        $stmt->bindValue(2, $userd['prenom']);
        $stmt->bindValue(3, $userd['username']);
        $stmt->bindValue(4, $userd['mail']);
        
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }


}