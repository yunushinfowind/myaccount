<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
ob_start();
class AppController extends Controller {

    //public $components = array('Session', 'Cookie', 'Auth', 'Paginator', 'Email');

    public $components = array(
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            )
        ), 'Session', 'Cookie', 'Paginator', 'Email'
    );
    public $helpers = array('Html', 'Form', 'Js', 'Session', 'Cache');

    public function beforeFilter() {
        //$this->clearstatcache();
        //  parent::beforeFilter();
        //$this->Auth->userModel = 'Admin';
        $this->Auth->userModel = 'User';
        $url = Router::url(NULL, true); //complete url
        if (!preg_match('/login|images|Css|css|logout|password|webadmin|login|logout|.png|.jpg|.gif|css|js|jpeg/i', $url)) {
            if ($url != BASE_URL && $url != BASE_URL . 'frontend/login') {
                $this->Session->write('lastUrl', $url);
            }
        }
        //$this->Cookie->type('rijndael'); //Enable AES symetric encryption of cookie
        if (isset($this->params['prefix']) && $this->params['prefix'] == 'webadmin') {
            $this->Auth->userModel = 'Admin';
            AuthComponent::$sessionKey = 'Auth.Admin';
            $this->Auth->logoutRedirect = $this->Auth->loginAction = array('prefix' => 'webadmin', 'controller' => 'login', 'action' => 'index', 'webadmin' => true);
            $this->Auth->loginError = 'Invalid Username/Password Combination!';
            $this->Auth->flash['element'] = 'admin_error';
            $this->Auth->loginRedirect = array('prefix' => 'webadmin', 'controller' => 'dashboard', 'action' => 'index', 'webadmin' => true);
            $this->loadModel('Admin');
            $admin_detail = $this->Admin->findById($this->Auth->user('id'));
            $this->set('admin_detail', $admin_detail);
        } else {
            //  $this->Auth->userModel = 'User';
            $this->loadModel('User');
            $this->loadModel('Message');
            $this->Auth->loginAction = array('controller' => 'frontend', 'action' => 'login');
            $this->Auth->userScope = array('User.status' => 1);
            $this->Auth->fields = array('email' => 'email', 'password' => 'pass');
            $this->Auth->loginError = 'Invalid Email/Password Combination!';
            $this->Auth->authError = 'Please login to view this page!';
            $this->Auth->flashElement = "front_error";
            AuthComponent::$sessionKey = 'User';
            //  $this->Auth->loginAction = array('prefix' => false, 'controller' => 'frontend', 'action' => 'login');
            if ($this->Auth->loggedIn()) {
                $user = $this->Auth->user();
             //   pr($user);
                //die;
                if ($user['role'] == '2') {
                    $teacher = $this->Auth->user();
                    $id = $teacher['id'];
                    $teacherInfo = $this->User->find('first', array('conditions' => array('User.id' => $id)));
                    $this->set('teacherInfo', $teacherInfo);
                    // $this->redirect(BASE_URL . 'teacher');
                } elseif ($user['role'] == '1') {
                    $student = $this->Auth->user();
                    $id = $student['id'];
                    $studentinfo = $this->User->find('first', array('conditions' => array('User.id' => $id)));
                    $this->set('studentinfo', $studentinfo);
                    // $this->redirect(BASE_URL . 'student');
                }
            }
            //  $this->Auth->logoutRedirect = $this->Auth->loginAction = array('prefix' => false, 'controller' => 'frontend', 'action' => 'login');
            //  $this->Auth->loginError = 'Invalid Email/Password Combination!';
            //  $this->Auth->flashElement = "auth.front.message";
        }
    }

    public function beforeRender() {
        $this->loadModel('Message');
        $messagecount = $this->Message->find('count', array('conditions' => array('Message.message_status' => 'unread', 'Message.send_to' => $this->Auth->User('id'))));
        $this->set('messagecount', $messagecount);
    }

    public function renderErrors($errors = null) {
        $errorP = '';
        if (!count($errors) or empty($errors)) {
            return '<div class="alert alert-error"><button data-dismiss="alert" class="close"></button><strong>Error Occured. Please try again. </strong></div>';
        }
        foreach ($errors as $error) {
            $errorP .= '<p>' . $error[0] . '</p>';
        }
        return $errorP = '<div class="alert alert-error"><button data-dismiss="alert" class="close"></button><strong>' . $errorP . '</strong></div>';
    }

    function clearstatcache() {

        if (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['REQUEST_URI'] == '/webadmin') {
            # die('uuu');
            $this->redirect(BASE_URL . 'webadmin');
            exit();
        } elseif (!isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            # die('uuu');
            $this->redirect(BASE_URL);
            exit();
        }
        return TRUE;
    }

    public function getMailerForAddress($email) {
        $domains = array("ameritech.net", "att.net", "bellsouth.net", "flash.net", "nvbell.net", "pacbell.net", "prodigy.net", "sbcglobal.net", "snet.net", "swbell.net", "wans.net", "severino.us");
        $this->log($domains, 'debug');
        $emailArr = preg_split('/@/', strtolower($email));
        $this->log($emailArr, 'debug');
        if (in_array($emailArr[1], $domains)) {
            $this->log($email." = found blocking domain", 'debug');
            return new CakeEmail('gmail');
        } else {
            $this->log($email." - did not find blocking domain", 'debug');
            return new CakeEmail('gmail');
        }
    }

    public function logActivity($user_id, $teacher_id, $calendar_id, $action, $activity, $amount, $amount_unit, $pack, $pricing_type, $admin_action, $success, $message) {
        $this->loadModel("Activity");

        $data['Activity']['user_id'] = $user_id;
        $data['Activity']['teacher_id'] = $teacher_id;
        $data['Activity']['calendar_id'] = $calendar_id;
        $data['Activity']['action'] = $action;
        $data['Activity']['activity'] = $activity;
        $data['Activity']['amount'] = $amount;
        $data['Activity']['amount_unit'] = $amount_unit;
        $data['Activity']['pack'] = $pack;
        $data['Activity']['pricing_type'] = $pricing_type;
        $data['Activity']['admin_action'] = $admin_action ? 1 : 0;
        $data['Activity']['success'] = $success  ? 1 : 0;
        $data['Activity']['message'] = $message;

        $this->log("Logging Activity:", "debug");
        $this->log($data, "debug");

        $this->Activity->create();
        $this->Activity->save($data);


    }


}
