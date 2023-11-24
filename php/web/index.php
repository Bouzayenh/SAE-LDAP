<?php


use App\LDAP\controller\ControllerDefault;
use App\LDAP\Lib\Psr4AutoloaderClass;

require_once __DIR__ . '/../src/lib/Psr4AutoloaderClass.php';


// On instancie un namespace pour faciliter l'importation de classes dans notre projet
$loader = new Psr4AutoloaderClass();

$loader ->addNamespace('App\LDAP', __DIR__.'/../src/');

$loader -> register();

if(isset($_GET['action'])){
    $action = $_GET['action'];
    if(isset($_GET['controller'])){
        $controller = $_GET['controller'];
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

?>

