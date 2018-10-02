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

require '../app/Controllers/Posts.php';

require '../Core/Router.php';
$router = new Router();
//echo get_class($router);

//Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('{controller}/{action}');

$router->add('{controller}/{id:\d+}/{action}');

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




