<?php

/**
 * Front Controller
 *
 * PHP version 7.2
 */

//echo 'Requested URL = "' . $_SERVER['QUERY_STRING'] . '"';

/**
 * Routing
 */

//require '../app/Controllers/Posts.php';
//require '../app/Controllers/Home.php';
//require '../Core/Router.php';

/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Autoloader
 */

//spl_autoload_register(function ($class){
//    $root = dirname(__DIR__); //get the parent directory
//    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
//    if(is_readable($file)){
//        require $root . '/' . str_replace('\\', '/', $class) . '.php';
//    }
//});

$router = new Core\Router();
//echo get_class($router);

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('/posts', ['controller' => 'Posts', 'action' => 'index']);

$router->add('{controller}/{action}');

$router->add('{controller}/{id:\d+}/{action}');

$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

//$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
//$router->add('posts/create', ['controller' => 'Posts', 'action' => 'create']);
//$router->add('admin/{action}/{controller}');

//Display the routing table
//echo '<pre>';
//var_dump($router->getRoutes());
//echo '<pre>';

//Match the requested route
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);

//echo '<pre>';
//echo htmlspecialchars(print_r($router->getRoutes(), true));
//echo '<pre>';
//
//if($router->match($url)){
//    echo '<pre>';
//    var_dump($router->getParameters());
//    echo '<pre>';
//} else {
//    echo "No route found for URL: " . $url;
//}




