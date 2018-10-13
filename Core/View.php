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
            echo "$file not found";
        }
    }
}