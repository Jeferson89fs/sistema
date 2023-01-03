<?php

namespace App\Utils;

class View
{

    private static function getContentView($view, $vars)
    {

        if (!empty($vars)) {
            extract($vars);
        }
        if (is_string($view)) {
            $nomeView = explode('/', $view);

            $file = $_SERVER['DOCUMENT_ROOT']  . "/app/resources/View/" . implode('/', array_map('ucfirst', $nomeView)) . ".php";

            $html = '';

            if (file_exists($file)) {
                ob_start();
                include $file;
                $html  = ob_get_clean();
            } else {
                echo 'view nao existe ( ' . $file . ' )';
            }
        } else {

            $html = '';
            foreach ($view as $view2) {
                $nomeView = explode('/', $view2);

                $file = $_SERVER['DOCUMENT_ROOT']  . "/app/resources/View/" . implode('/', array_map('ucfirst', $nomeView)) . ".php";

                if (file_exists($file)) {
                    ob_start();
                    include $file;
                    $html  .= ob_get_clean();
                } else {
                    echo 'view nao existe ( ' . $file . ' )';
                }
            }
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
    public static function render($view, $vars = [], $includeHeaderFooter = true, $namespace = 'template')
    {
        $contentView = '';


        if ($includeHeaderFooter) {
            $contentView .= self::getContentView($namespace . '/Header', $vars);
        }

        $contentView .= self::getContentView($view, $vars);

        if ($includeHeaderFooter) {
            $contentView .= self::getContentView($namespace . '/Footer', $vars);
        }



        return $contentView;
    }
}
