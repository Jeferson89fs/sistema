<?php

namespace App\Controller\Admin;

use App\Utils\View;

abstract  class AbstractController
{

    protected $menu;

    protected $currentPage = 'home';

    public function __construct()
    {
        $this->initMenu();
    }


    protected function initMenu()
    {
        $menuLinks = Menu::getMenuAdmin($this->currentPage);

        $this->menu = View::render('Admin/Menu/box', [
            'menuLinks' => $menuLinks
        ], false, 'Admin');

        //return $menu;
    }
}
