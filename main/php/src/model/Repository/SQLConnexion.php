<?php
namespace App\LDAP\model\Repository;

use App\LDAP\config\ConfSql;

class SQLConnexion {
    private static $sqlConnexion = null;

    private static function connect() {
        try{
            $sql_host = ConfSql::$sql_host;
            $username = ConfSql::$username;
            $password = ConfSql::$password;
            $dbname = ConfSql::$dbname;
            $sql_conn = new \PDO("mysql:host=$sql_host;dbname=$dbname", $username, $password);
            $sql_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $sql_conn;
        }catch(\PDOException $e){
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (is_null(self::$sqlConnexion)) {
            self::$sqlConnexion = self::connect();
        }
        return self::$sqlConnexion;
    }

}