<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * Render a view file
     *
     * @param string $view The view file
     *
     * @return void
     */
    public static function render($view, $args = []){
        extract($args, EXTR_SKIP);
        $file = "../app/Views/$view";   //relative to the Core directory

        if (is_readable($file)){
            require $file;
        } else {
//            echo "$file not found";
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a template using Twig
     *
     * @param string $template The template file
     * @param array $args Associative array to display data in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = null){
        static $twig = null;
        if($twig === null){
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/app/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}