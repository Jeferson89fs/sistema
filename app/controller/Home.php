<?php

namespace App\Controller;

use App\Utils\View;

class Home
{

    public function getHome()
    {
        return View::render('pages/home', [
            
        ],true,'pages');
    }
    
}
