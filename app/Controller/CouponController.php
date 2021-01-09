<?php

class CouponController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function webadmin_add() { // to add coupon in db
        $this->layout = 'admin';
        $this->loadModel('Coupon');
        if ($this->request->is('post')) {
            if ($this->Coupon->validates()) {
                if ($this->Coupon->save($this->request->data)) {
                    $this->Session->setFlash(__('Coupon added successfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'coupon', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Coupon->validationErrors;
        }
    }

    public function webadmin_index() { //show all added coupons
        $this->layout = 'admin';
        $this->loadModel('Coupon');
        $coupons = $this->Coupon->find('all');
        //pr($coupons);
        //die;
        $this->set('coupons', $coupons);
    }

    public function webadmin_change_status($id, $status) { //change status of the added coupon to active/inactive
        $this->loadModel('Coupon');
        $iduser = $this->Coupon->findById($id);
        if ($iduser['Coupon']['status'] == '0') {
            $this->Coupon->updateAll(array('Coupon.status' => "1"), array('Coupon.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->Coupon->updateAll(array('Coupon.status' => "0"), array('Coupon.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        return $this->redirect(array('controller' => 'coupon', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    public function webadmin_delete_coupon($id = NULL) { //to delete the added coupon
        $this->autoRender = FALSE;
        $this->loadModel('Coupon');
        $this->Coupon->delete($id);
        $this->Session->setFlash('Coupon deleted Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'coupon', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    public function webadmin_edit_coupon($id = NULL) { //update the added coupon
        $this->layout = 'admin';
        $this->loadModel('Coupon');
        $findCoupon = $this->Coupon->find('first', array('conditions' => array('Coupon.id' => $id)));
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            if ($this->Coupon->validates()) {
                $this->Coupon->id = $id;
                if ($this->Coupon->save($this->request->data)) {
                    $this->Session->setFlash(__('Coupon updated succesfully.'), 'admin_success');
                    $this->redirect(array('controller' => 'coupon', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Coupon->validationErrors;
        }
        if (empty($this->request->data)) {
            $this->set('findCoupon', $findCoupon);
        }
        $this->set('findCoupon', $findCoupon);
    }

}
