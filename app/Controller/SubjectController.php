<?php

class SubjectController extends AppController {
 public function beforeFilter() {
        parent::beforeFilter();
    }
    //subjects added from admin panel
    public function webadmin_add() {
	$this->layout = 'admin';
	$this->loadModel('Subject');
	if ($this->request->is('post')) {
	    if ($this->Subject->validates()) {
		if ($this->Subject->save($this->request->data)) {
		    $this->Session->setFlash(__('Subject added succesfully.'), 'admin_success');
		    $this->redirect(array('controller' => 'subject', 'action' => 'index', 'prefix' => 'webadmin'));
		}
	    }
	} else {
	    $errors = $this->Subject->validationErrors;
	}
    }

    // subjects managed
    public function webadmin_index() {
	$this->layout = 'admin';
	$this->loadModel('Subject');
	$subjects = $this->Subject->find('all', array('conditions' => array(), 'order' => array('Subject.id' => 'DESC')));
	$this->set('subjects', $subjects);
    }

    //change status of the subject added 
    public function webadmin_change_status($id = NULL) {
	$this->loadModel('Subject');
	$iduser = $this->Subject->findById($id);
	if ($iduser['Subject']['status'] == '0') {
	    $this->Subject->updateAll(array('Subject.status' => "1"), array('Subject.id' => $id));
	    $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
	} else {
	    $this->Subject->updateAll(array('Subject.status' => "0"), array('Subject.id' => $id));
	    $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
	}
	return $this->redirect(array('controller' => 'subject', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    // delete an existing subject.
    public function webadmin_delete_subject($id = NULL) {
	$this->autoRender = FALSE;
	$this->loadModel('Subject');
	$this->Subject->delete($id);
	$this->Session->setFlash('Subject deleted Successfully.', 'admin_success');
	$this->redirect(array('controller' => 'subject', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    // edit or update an existing subject.
    public function webadmin_edit_subject($id = NULL) {
	$this->layout = 'admin';
	$this->loadModel('Subject');
	$subject = $this->Subject->find('first', array('conditions' => array('Subject.id' => $id)));
	$this->set('subject', $subject);
	if ($this->request->is('put') or $this->request->is('post')) {
	    if ($this->Subject->validates()) {
		$this->Subject->id = $id;
		if ($this->Subject->save($this->request->data)) {
		    $this->Session->setFlash(__('Subject updated succesfully.'), 'admin_success');
		    $this->redirect(array('controller' => 'subject', 'action' => 'index', 'prefix' => 'webadmin'));
		}
	    }
	} else {
	    $errors = $this->Subject->validationErrors;
	}
    }

    public function webadmin_order() {
	$this->autoRender = FALSE;
	if (!empty($_POST['subject_id']) && !empty($_POST['order'])) {
	    $this->Subject->id = $_POST['subject_id'];
	    $this->Subject->saveField('order', $_POST['order']);
	    $response['status'] = 'saved';
	    echo json_encode($response);
	    die;
	}
    }

}
