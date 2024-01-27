<?php

use App\LDAP\controller\ControllerDefault;
use App\LDAP\Lib\Psr4AutoloaderClass;

require_once __DIR__ . '/../src/lib/Psr4AutoloaderClass.php';


// On instancie un namespace pour faciliter l'importation de classes dans notre projet
$loader = new Psr4AutoloaderClass();

$loader ->addNamespace('App\LDAP', __DIR__.'/../src/');

$loader -> register();

// ON initialise le base de données sql
\App\LDAP\controller\ControllerSQL::initDatabaseWithLDAPUsers();

$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action']: false);
echo "Action=$action";
if($action){
    $controller = isset($_POST['controller']) ? $_POST['controller'] : $_GET['controller'];
    if($controller){
        $ClassController ='App\LDAP\controller\Controller' . $controller;
        if(class_exists($ClassController)){
            $ClassController::$action();
        }
        else{
            ControllerDefault::notFound();
        }
    }
    else{
        ControllerDefault::notFound();
    }
}
else{
    ControllerDefault::homepage();
}
