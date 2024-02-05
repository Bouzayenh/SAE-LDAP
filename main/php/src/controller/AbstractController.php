<?php

namespace App\LDAP\controller;



abstract class AbstractController{

    public static function afficheVue(string $cheminVue, array $parametres = []): void{
        extract($parametres);
        require __DIR__."/../view/$cheminVue";
    }

}