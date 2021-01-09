<?php

class PackController extends AppController {
 public function beforeFilter() {
        parent::beforeFilter();
    }
    //adding pack
    public function webadmin_add() {
        $this->layout = 'admin';
        $this->loadModel('pack');
        if ($this->request->is('post')) {
            if ($this->Pack->validates()) {
                if (!empty($this->request->data['Pack']['hours']) && (!empty($this->request->data['Pack']['minutes']))) {
                    $total = ($this->request->data['Pack']['hours'] * 60) + $this->request->data['Pack']['minutes'];
                } elseif ($this->request->data['Pack']['hours']) {
                    $total = $this->request->data['Pack']['hours'] * 60;
                } elseif ($this->request->data['Pack']['minutes']) {
                    $total = $this->request->data['Pack']['minutes'];
                }
                $this->request->data['Pack']['duration'] = $total;
                if ($this->Pack->save($this->request->data)) {
                    $this->Session->setFlash(__('Pack added succesfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'pack', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Pack->validationErrors;
        }
    }

    //managing pack
    public function webadmin_index() {
        $this->layout = 'admin';
        $this->loadModel('Pack');
        $packs = $this->Pack->find('all', array(
            'order' => array('Pack.id' => 'ASC')));
        $this->set('packs', $packs);
    }

    // change status for added pack
    public function webadmin_change_status($id = NULL) {
        $this->loadModel('Pack');
        $iduser = $this->Pack->findById($id);
        if ($iduser['Pack']['status'] == '0') {
            $this->Pack->updateAll(array('Pack.status' => "1"), array('Pack.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->Pack->updateAll(array('Pack.status' => "0"), array('Pack.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        return $this->redirect(array('controller' => 'pack', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    // delete added pack
    public function webadmin_delete_pack($id = NULL) {
        $this->autoRender = FALSE;
        $this->loadModel('Pack');
        $this->Pack->delete($id);
        $this->Session->setFlash('Pack deleted Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'pack', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    //edit or update already existed pack
    public function webadmin_edit_pack($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Pack');
        $pack = $this->Pack->find('first', array('conditions' => array('Pack.id' => $id)));
        $this->set('pack', $pack);
        if ($this->request->is('put') or $this->request->is('post')) {
            if ($this->Pack->validates()) {
                if (!empty($this->request->data['Pack']['hours']) && !empty($this->request->data['Pack']['minutes'])) {
                    $total = ($this->request->data['Pack']['hours'] * 60) + $this->request->data['Pack']['minutes'];
                } elseif ($this->request->data['Pack']['hours']) {
                    $total = $this->request->data['Pack']['hours'] * 60;
                } elseif ($this->request->data['Pack']['minutes']) {
                    $total = $this->request->data['Pack']['minutes'];
                }
                $this->request->data['Pack']['duration'] = $total;
                $this->Pack->id = $id;
                if ($this->Pack->save($this->request->data)) {
                    $this->Session->setFlash(__('Pack updated succesfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'pack', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Pack->validationErrors;
        }
    }

}
