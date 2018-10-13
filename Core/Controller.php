<?php

namespace Core;


abstract class Controller
{
    /**
     * Parameters from the matched method
     * @var array
     */
    protected $params = [];

    /**
     * Class constructor
     *
     * @param array  $params Parameters from the route
     *
     * @return void
     */
    public function __construct($params){
        $this->params = $params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $arguments){
        $method = $name . 'Action';

        if(method_exists($this, $method)){
            if($this->before() !== false){
                call_user_func_array([$this, $method], $arguments);
                $this->after();
            }
        } else {
            echo "Method $method not found in controller " . get_class($this);
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before(){}

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after(){}

}