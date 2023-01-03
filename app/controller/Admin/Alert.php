<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Alert
{


    public static function getSuccess($messsage)
    {
        return View::render('Admin/Alert', [
            'message' => $messsage,
            'type' => 'success'
        ],false);
    }

    public static function getError($messsage)
    {
        return View::render('Admin/Alert', [
            'message' => $messsage,
            'type' => 'danger'
        ],false);
    }

    public static function getInfo($messsage)
    {
        return View::render('Admin/Alert', [
            'message' => $messsage,
            'type' => 'primary'
        ],false);
    }

    public static function getAlert($messsage)
    {
        return View::render('Admin/Alert', [
            'message' => $messsage,
            'type' => 'warning'
        ],false);
    }
}
