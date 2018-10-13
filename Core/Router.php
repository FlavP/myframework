<?php

namespace Core;

class Router
{

    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $parameters = [];

    /**
     * Add a route to the routing table
     *
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc.)
     *
     * @return void
     */

    public function add($route, $params = []){
        // Convert the route to a regular expression: escape forward slashes
        // Cauti slash (/) in $route si le inlocuiesti cu (\) pentru a putea crea subgrupuri
        // De expresii regulate, astfel incat fiecare componenta a url-ului, delimitat de (/)
        // Sa devina un subgrup (variabila) de expresii regulate
        $route = preg_replace('/\//', '\\/',$route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //Add star and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;

    }

    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    public function getRoutes(){
        return $this->routes;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @param string $url the route URL
     *
     * @return boolean true if a match is found, false otherwise
     */
    public function match($url){
//        foreach ($this->routes as $route => $params) {
//            if($url == $route){
//                $this->parameters = $params;
//                return true;
//            }
//        }

//        Match to the fixed URL format controller/action
//        $reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
//                $params = [];
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->parameters = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParameters(){
        return $this->parameters;
    }

    /**
     * Dispatch the route, creating the controller object and running
     * the action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch($url){
        $url = $this->removeQueryStringVariables($url);
        if($this->match($url)){
            $controller = $this->parameters['controller'];
            $controller = $this->convertToStudlyCaps($controller);
//            $controller = "app\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if(class_exists($controller)){
                $controllerObject = new $controller($this->parameters);

                $action = $this->parameters['action'];
                $action = $this->convertToCamelCase($action);

                if(preg_match('/action$/i', $action) == 0){
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
            } else {
                echo "Controller class $controller not found.";
            }
        } else {
            echo "No route matched.";
        }
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    public function convertToStudlyCaps($string){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    public function convertToCamelCase($string){
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Clean query string variables
     *
     * @param string $url
     *
     * @return string the URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url){
        if($url != ''){
            $parts = explode('&', $url, 2);
            if(strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace(){
        $namespace = 'app\Controllers\\';

        if(array_key_exists('namespace', $this->parameters)){
            $namespace .= $this->parameters['namespace'] . '\\';
        }

        return $namespace;
    }
}