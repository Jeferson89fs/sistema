<?php

namespace App\Core;

use App\Utils\View;
use App\Core\Router;

class Paginate
{

    private $total;
    private $per_page;
    private $current_page;
    private $last_page;

    private $first_page_url;
    private $last_page_url;
    private $next_page_url;
    private $prev_page_url;
    private $path;
    private $from = 1;
    private $to;
    private $data  = array();

    public function __construct($result, $total)
    {

        $this->total =  $total;
        $this->per_page =  LIMIT;
        $this->per_page = $_REQUEST['page'] ?? 1;
        $this->last_page = (ceil($total / LIMIT));
        $this->path = BASE_HTTP.substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING'])-1);;        
        $this->to = LIMIT;

        $this->first_page_url = $this->path.'/?page='.$this->from ;
        $this->last_page_url = $this->path.'/?page='.$this->to ;

        
        $prev_page_url = $this->current_page < $this->from ? 1 : $this->current_page + 1;
        $this->prev_page_url = $this->path.'?page='.$prev_page_url ;

        $this->next_page_url = $this->path.'?page='.$this->last_page ;

        foreach ($result as $obj) {
            array_push($this->data, $obj);
        }
    }

    public function pagination()
    {
        $link = '';

        for ($i = ($this->from ?? 1); $i <= $this->last_page; $i++) {

            $link .=  View::render(
                'Admin/Paginacao/Link',
                [
                    'paginacao'  => $this,
                    'page'      => $i,
                    'path'      => $this->path,
                ],
                false,
                'Admin'
            );
        }



        return View::render(
            'Admin/Paginacao/Index',
            [
                'paginacao'  => $this,
                'link'      => $link,
                'prev'      => $this->prev_page_url,
                'next'      => $this->next_page_url,
            ],
            false,
            'Admin',

        );
    }
}
