<?php

class LoginController extends AppController {
 public function beforeFilter() {
        parent::beforeFilter();
    }
    //admin panel login
    public function webadmin_index() {
        $this->layout = "admin_login";
        $this->loadModel('Admin');
        if ($this->request->is('post')) {
            $conds = array(
                'Admin.username' => $this->request->data['Admin']['username'],
                'Admin.password' => Security::hash($this->request->data['Admin']['password'], null, true)
            );
            $admin = $this->Admin->find('first', array('conditions' => $conds));

            if ($admin) {
                $this->Auth->login($admin['Admin']);
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Invalid Username Or Password', 'admin_loginerror');
            }
        }
        if ($this->Auth->loggedIn() || $this->Auth->login()) {
            return $this->redirect($this->Auth->redirectUrl());
   //         return $this->redirect(BASE_URL . 'webadmin/dashboard');
        }
    }

    //admin logout
    public function webadmin_logout() {
        $this->Auth->logout();
//	return $this->redirect($this->Auth->logout());
        return $this->redirect(BASE_URL . 'webadmin');
    }

    public function webadmin_change_password() {
        $this->layout = 'admin';
        $this->loadModel('Admin');
        $admin = $this->Auth->user();
        $admin_id = $admin['id'];
        $getUser = $this->Admin->find('first', array('conditions' => array('Admin.id' => $admin_id)));
        $password = $getUser['Admin']['password'];
        if ($this->request->is('post')) {
            $old_password = AuthComponent::password($this->request->data['Admin']['old_password']);
            $new_pass = AuthComponent::password($this->request->data['Admin']['new_password']);
            $confirm_password = AuthComponent::password($this->request->data['Admin']['confirm_password']);
            if ($old_password == $password) {
                if ($new_pass == $confirm_password) {
                    $update_pass['Admin']['password'] = $new_pass;
                    $this->Admin->id = $admin_id;
                    if ($this->Admin->save($update_pass)) {
                        $this->Session->setFlash(__('Password changed succesfully.'), 'success');
                        $this->redirect(array('controller' => 'login', 'action' => 'change_password', 'prefix' => 'webadmin'));
                    }
                } else {
                    $this->Session->setFlash(__('Confirm Passwords does not match.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Passwords does not match.'), 'error');
            }
        }
    }

    public function webadmin_change_details() {
        $this->layout = 'admin';
        $this->loadModel('Admin');
        $admin = $this->Auth->user();
        $find = $this->Admin->findById($admin['id']);
        $this->set('admin_detail', $find);

        if ($this->request->is('put') || ($this->request->is('post'))) {
            if (!empty($this->request->data['Admin']['image']['name'])) {
                $image = $this->request->data['Admin']['image'];
                $this->request->data['Admin']['image'] = $this->request->data['Admin']['image']['name'];
                $this->request->data['Admin']['image'] = time() . '_' . $this->request->data['Admin']['image'];
                move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/admin_images/' . $this->request->data['Admin']['image']);
            } else {
                $this->request->data['Admin']['image'] = $find['Admin']['image'];
            }
            $this->Admin->id = $find['Admin']['id'];
            if ($this->Admin->save($this->request->data)) {
                $this->Session->setFlash(__('Details Updated successfully.'), 'admin_success');
                return $this->redirect(array('action' => 'change_details'));
            }
        }
    }

    public function webadmin_remove_image() {
        $this->layout = 'ajax';
        $this->loadModel('Admin');
        $id = $_POST['id'];
        if (!empty($id) && isset($id)) {
            $this->Admin->id = $id;
            $this->Admin->saveField('image', '');
            $res['status'] = 'yes';
        } else {
            $res['status'] = 'no';
        }
        echo json_encode($res);
        die;
    }

}
