<?php

class UserController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        //die('jjj');
        // $this->Auth->allow(array('index', 'forgot_password', 'password', 'pricing', 'login'));
    }

    public function logout() {
      //  die('hh');
        $this->Session->destroy();
        return $this->redirect($this->Auth->logout());
    }

}
