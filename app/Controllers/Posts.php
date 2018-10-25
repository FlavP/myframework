<?php
namespace app\Controllers;

use Core\Controller;
use \Core\View;

/**
 * Posts controller
 */
class Posts extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction(){
//        echo "Hello from the index action in the Posts controller!";
//        echo '<p> string parameters: <pre>' . htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
        View::renderTemplate('Posts/index.html.twig', []);
    }

    /**
     * Show the add new page
     *
     * @return void
     */
    public function addNewAction(){
        echo "Hello from the Add New action in the Posts controller!";
    }

    /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction(){
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>'.
            htmlspecialchars(print_r($this->params, true)) . '</pre></p>';
    }
}