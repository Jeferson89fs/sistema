<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Controller\Admin\AbstractController;
use App\Model\Depoimento as ModelDepoimento;

class Depoimento extends AbstractController
{

    protected $currentPage = 'depoimento';

    public function index()
    {

        
        $objDepoimento = new ModelDepoimento;
        $objDepoimento = $objDepoimento->fillObject($_REQUEST);

        foreach($objDepoimento->atributes as $c => $v){
            $objDepoimento->where($c, 'like', $v);
        }

        $objPaginate = $objDepoimento->paginate(intval($_REQUEST['page'] ?? 1) );

       // dd($objPaginate);
  

        $alert = '';

        return View::render(
            [
                'Admin/Depoimento/Index',
                'Admin/Depoimento/List',
            ],
            [
                'alert' => $alert,
                'title' => 'Depoimentos',
                'content' => 'content',
                'menu'  => $this->menu,
                'paginacao'  => $objPaginate->pagination()
            ],
            true,
            'Admin',

        );
    }
}
