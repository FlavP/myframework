<?php

namespace app\Controllers;

use Core\Controller;
use Core\View;

class Home extends Controller
{
    public function indexAction(){
//        View::render('Home/index.php', [
//            'name' => 'Dave',
//            'colors' => ['red', 'green', 'blue']
//        ]);

        View::renderTemplate('Home/index.html.twig', [
            'name' => 'Dave',
            'colors' => ['red', 'green', 'blue']
        ]);
    }

    /**Before filter
     * @return void
     */
    protected function before()
    {

    }

    /**After filter
     * @return void
     */
    protected function after()
    {

    }
}