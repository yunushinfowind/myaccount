<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'frontend', 'action' => 'login'));
Router::connect('/users/login', array('controller' => 'frontend', 'action' => 'login'));
//Router::connect('/', array('controller' => 'frontend', 'action' => 'index'));

Router::connect('/webadmin', array('controller' => 'login', 'action' => 'index', 'prefix' => 'webadmin', 'webadmin' => true));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
$url = array_filter(explode("/", Router::url(array('controller' => 'frontend', 'action' => 'login'))));

/*
 * Get Controllers list
 */
$Controllers = App::objects('frontend');
$CleanControllers = array();

/*
 * Remove string 'Controller' from element
 * lower string
 */
foreach ($Controllers as $Controller) {
    $CleanControllers[] = strtolower(str_replace('Controller', '', $Controller));
}

/*
 * Check if first element, from URL, is NOT a controllers array
 */
if (!in_array(strtolower(reset($url)), $CleanControllers)) {
    /*
     * Forward to "Pages" controller 
     */
    Router::connect('/', array('controller' => 'frontend', 'action' => 'index', 'home'));
}

CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';