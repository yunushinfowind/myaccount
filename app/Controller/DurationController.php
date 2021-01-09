<?php

class DurationController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    // add duration
    public function webadmin_add() {
        $this->layout = 'admin';
        $this->loadModel('Duration');
        if ($this->request->is('post')) {
            if ($this->Duration->validates()) {
                if ($this->Duration->save($this->request->data)) {
                    $this->Session->setFlash(__('Duartion added successfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'duration', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Duration->validationErrors;
        }
    }

    //manage duration 
    public function webadmin_index() {
        $this->layout = 'admin';
        $this->loadModel('Duration');
        $durations = $this->Duration->find('all');
        $this->set('durations', $durations);
    }

    // change status of the added duration
    public function webadmin_change_status($id = NULL) {
        $this->loadModel('Duration');
        $iduser = $this->Duration->findById($id);
        if ($iduser['Duration']['status'] == '0') {
            $this->Duration->updateAll(array('Duration.status' => "1"), array('Duration.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->Duration->updateAll(array('Duration.status' => "0"), array('Duration.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        return $this->redirect(array('controller' => 'duration', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    // delete duration data
    public function webadmin_delete_duration($id = NULL) {
        $this->autoRender = FALSE;
        $this->loadModel('Duration');
        $this->Duration->delete($id);
        $this->Session->setFlash('Duration deleted Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'duration', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    //editing an existing duration
    public function webadmin_edit_duration($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Duration');
        $duration = $this->Duration->find('first', array('conditions' => array('Duration.id' => $id)));
        $this->set('duration', $duration);
        if ($this->request->is('post') or $this->request->is('put')) {
            if ($this->Duration->validates()) {
                $this->Duration->id = $id;
                if ($this->Duration->save($this->request->data)) {
                    $this->Session->setFlash(__('Duration updated successfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'duration', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Duration->validationErrors;
        }
    }

}
