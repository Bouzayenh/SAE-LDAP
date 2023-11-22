<?php

namespace App\LDAP\controller;


use App\LDAP\controller\AbstractController;

class ControllerDefault extends AbstractController{


    public static function chooseDirectory(){
        self::afficheVue("directorySelection.php", ["Pagetitle" => "Select Local or IUT"]);
    }
    public static function notFound(){
        self::afficheVue("NotFound.php");
    }
}