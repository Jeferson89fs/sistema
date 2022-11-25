<?php

namespace App\Utils;

class View
{

    private static function getContentView($view, $vars)
    {
        extract($vars);
        $nomeView = explode('/', $view);
        $file =  __DIR__ . "../../Resources/View/" . implode('/', array_map('ucfirst', $nomeView)) . ".php";

        $html = '';

        if (file_exists($file)) {
            ob_start();
            include $file;
            $html  = ob_get_clean();
        }

        return $html;
    }


    public static function render($view, $vars = [])
    {
        $contentView = self::getContentView($view, $vars);

        return $contentView;
    }
}
