<?php

namespace App\Controller\Pages;

use App\Utils\View;

class Home{

    static public function getHome(){        

        $teste = 'aaa';
        return View::render('pages/home', [ 'teste' => $teste]);
    }
}