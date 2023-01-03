<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Controller\Admin\AbstractController;

class Home extends AbstractController
{
    public function getIndex()
    {

        $alert = '';
        // $alert .= Alert::getSuccess('teste');
        // $alert .=Alert::getError('teste');
        // $alert .=Alert::getInfo('teste');
        // $alert .=Alert::getAlert('teste');


        return View::render(
            'Admin/Home/index',
            [
                'alert' => $alert,
                'title' => 'Inicio',
                'content' => 'content',
                'menu'  => $this->menu
            ],
            true,
            'Admin',

        );
    }
}
