<?php

class SettingController extends AppController {
 public function beforeFilter() {
        parent::beforeFilter();
    }
    public function webadmin_authorize_credentials() {
	$this->layout = 'admin';
	$this->loadModel('Authorize');
	$credentials = $this->Authorize->find('first');
	$this->set('credentials', $credentials);
	if ($this->request->is('post') || ($this->request->is('put'))) {
	    $this->Authorize->id = $credentials['Authorize']['id'];
	    if ($this->Authorize->save($this->request->data)) {
		$this->Session->setFlash(__('Credentials updated successfully.'), 'success');
		$this->redirect(array('action' => 'authorize_credentials'));
	    }
	}
    }

}
