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
        }else{
            echo 'view nao existe ( '.$file.' )';
        }

        return $html;
    }


    /**
     * Undocumented function
     *
     * @param string $view
     * @param array $vars
     * @param boolean $includeHeaderFooter
     * @param string $namespace
     * @return string
     */
    public static function render($view, $vars = [], $includeHeaderFooter=true, $namespace='template')
    {
        $contentView = '';

        if($includeHeaderFooter){                    
            $contentView .= self::getContentView($namespace.'/header', $vars);
        }
        
        $contentView .= self::getContentView($view, $vars);

        if($includeHeaderFooter){
            $contentView .= self::getContentView($namespace.'/footer', $vars);
        }

        return $contentView;
    }
}
