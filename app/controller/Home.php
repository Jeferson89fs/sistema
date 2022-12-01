<?php

namespace App\Controller;

use App\Utils\View;

class Home
{

    public function getHome($x)
    {
        $teste = 'parametro = ' . $x;

        return View::render('pages/home', [
            'teste' => $teste
        ]);
    }

    public function getHome2($x, $y)
    {
        $teste = 'parametro home 2 = ' . $x . ' = ' . $y;

        return View::render('pages/home', [
            'teste' => $teste
        ]);
    }
}
