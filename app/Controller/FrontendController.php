<?php

ob_start();

class FrontendController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'forgot_password', 'password', 'pricing', 'login'));
    }

    public function index() {
        $this->layout = 'front_login';
    }

    //to generate random string of 6 characters.
    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    // landing page login
    public function login() {
        $this->layout = 'front_login';
        $this->loadModel('User');
        $lastUrl = $this->Session->read('lastUrl');
        $user = $this->Auth->user();
        // pr($user);
        if (!empty($this->Auth->user())) {
            if ($this->Auth->user('role') == '1') {
                $this->redirect(BASE_URL . 'student');
            } else if ($this->Auth->user('role') == '2') {
                $this->redirect(BASE_URL . 'teacher');
            }
        }
        if ($this->request->is('post')) {
            $this->User->recursive = -1;
            $pass = $this->request->data['User']['password'];
            $conds = array(
                'User.email' => $this->request->data['User']['email'],
                'User.password' => AuthComponent::password($pass),
            );
            $user = $this->User->find('first', array('conditions' => $conds));
            // $this->Auth->login();
            //   pr($user); die;
            if (isset($user) && !empty($user)) {
                $this->Auth->login($user['User']);
                $data = $this->Auth->User();
                if ($user['User']['role'] == 1) {
                    if ($lastUrl == BASE_URL . 'student/make_payment') {
                        return $this->redirect(array('controller' => 'student', 'action' => 'make_payment'));
                    } else {
                        return $this->redirect(array('controller' => 'student', 'action' => 'index'));
                    }
                } elseif ($user['User']['role'] == 2) {
                    return $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                }
            } else {
                $this->Session->setFlash(__('Invalid Username Or Password.'), 'error');
            }
        }
    }

    // forgot password page.
    public function forgot_password() {
        $this->layout = 'front_login';
        $this->loadModel('User');
        $this->loadModel('Email_content');
        $this->User->recurisive = -1;        

        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Forgot Password')));
        if ($this->request->is('post')) {
            $email = $this->request->data['User']['email'];
            $getUser = $this->User->find('first', array('conditions' => array('User.email' => $email)));
            $id = $getUser['User']['id'];
            $this->User->id = $id;
            $token = $this->generateRandomString();
            $this->User->saveField('token', $token);
            $Email = $this->getMailerForAddress($email);
            $Email->template('forgot_password');
            $Email->viewVars(array('getUser' => $getUser, 'token' => $token, 'data' => $data));
            $Email->to($email);
            $Email->subject('Forgot Password.');
            $Email->send();
            $this->Session->setFlash(__('An email has been sent to the email to set the password'), 'success');
            return $this->redirect(array('action' => 'forgot_password'));
        }
    }

    //landing page on click of forgot password link.
    public function password() {
        $this->layout = 'front_login';
        $this->loadModel('User');
        $Urltoken = $this->params['pass'][0];
        $matchToken = $this->User->find('first', array('conditions' => array('User.token' => $Urltoken)));
        if ($this->request->is('post')) {
            $pasword = $this->request->data['User']['password'];
            $pass = AuthComponent::password($pasword);
            $this->User->id = $matchToken['User']['id'];
            $this->User->saveField('password', $pass);
            $this->User->saveField('token', '');
            $this->Session->setFlash(__('Password changed successfully.'), 'success');
            $this->redirect(BASE_URL);
        }
    }

    // page showing packs and pricing for each subject.
    public function pricing() {
        $this->layout = 'front_login';
        $this->loadModel('Price');
        $prices = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => '2')));

        function compare_lastname($a, $b) {
            return strnatcmp($a['Price']['subject'], $b['Price']['subject']);
        }

        usort($prices, 'compare_lastname');
        $this->set('prices', $prices);
    }

    // to change the password for both student as well as teacher
    public function change_password() {
        $this->layout = 'front_login';
        $user = $this->Auth->user();
        $userId = $user['id'];
        $getUser = $this->User->find('first', array('conditions' => array('User.id' => $userId)));
        $role = $getUser['User']['role'];
        $password = $getUser['User']['password'];
        if ($this->request->is('post')) {
            $old_password = AuthComponent::password($this->request->data['User']['old_password']);
            $new_pass = AuthComponent::password($this->request->data['User']['password']);
            $confirm_password = AuthComponent::password($this->request->data['User']['confirm_password']);
            if ($old_password == $password) {
                if ($new_pass == $confirm_password) {
                    $update_pass['User']['password'] = $new_pass;
                    $this->User->id = $userId;
                    if ($this->User->save($update_pass)) {
                        $this->Session->setFlash(__('Password changed succesfully.'), 'success');
                        if ($role == 1) {
                            $this->redirect(array('controller' => 'student', 'action' => 'index'));
                        } elseif ($role == 2) {
                            $this->redirect(array('controller' => 'teacher', 'action' => 'index'));
                        }
                    }
                } else {
                    $this->Session->setFlash(__('Confirm Passwords does not match.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Passwords does not match.'), 'error');
            }
        }
    }

}
