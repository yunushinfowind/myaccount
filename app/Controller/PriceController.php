<?php

class PriceController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
//        $this->Auth->allow(array(''));
    }

    public function webadmin_add() {
        $this->layout = 'admin';
        $this->loadModel('Subject');
        $this->loadModel('Pack');
        $this->loadModel('Price');
        $this->loadModel('Pricing_type');
        $subjects = $this->Subject->find('all', array('conditions' => array('Subject.status' => 1)));
        $this->set('subjects', $subjects);
        $packs = $this->Pack->find('all', array('conditions' => array('Pack.status' => 1), 'order' => array('Pack.order' => 'ASC')));
        $pricingTypes = $this->Pricing_type->find('all', array('conditions' => array('Pricing_type.enabled' => 1), 'order' => array('Pricing_type.id' => 'DESC')));
//        pr($packs);die;
        $this->set('packs', $packs);
        $this->set('pricing_types', $pricingTypes);
        if ($this->request->is('post')) {
            if ($this->Price->validates()) {
                $exp_pack = explode(',', $this->request->data['Price']['pack']);
                $find_pack = $this->Pack->findByPack($exp_pack[0]);

                $this->request->data['Price']['pack_id'] = $find_pack['Pack']['id'];
                $this->request->data['Price']['pack'] = $exp_pack[0];
                $this->request->data['Price']['duration'] = $exp_pack[1];
                $if_exists = $this->Price->find('first', array('conditions' => array('Price.pricing_type' => $this->request->data['Price']['pricing_type'], 'Price.pack' => $exp_pack[0])));
                if (empty($if_exists)) {
                    if ($this->Price->save($this->request->data)) {
                        $this->Session->setFlash('Price added Successfully.', 'admin_success');
                        $this->redirect(array('controller' => 'price', 'action' => 'index', 'prefix' => 'webadmin'));
                    }
                } else {
                    $this->Session->setFlash('The pack for the pricing type already exists.', 'error');
                }
            }
        } else {
            $errors = $this->Price->validationErrors;
        }
    }

    public function webadmin_index() {
        $this->layout = 'admin';
        $this->loadModel('Pricing_type');
        $pricing_types = $this->Pricing_type->find('all', array('order' => array('Pricing_type.enabled DESC', 'Pricing_type.id DESC')));
        $this->set('pricing_types', $pricing_types);
    }

    public function webadmin_change_status($id = NULL) {
        $this->loadModel('Price');
        $iduser = $this->Price->findById($id);
        $sub = $iduser['Price']['subject'];
        if ($iduser['Price']['status'] == '0') {
            $this->Price->updateAll(array('Price.status' => "1"), array('Price.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->Price->updateAll(array('Price.status' => "0"), array('Price.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        return $this->redirect(BASE_URL . 'webadmin/price/view/' . $sub);
    }

    public function webadmin_edit_price($id = NULL) {
        if(is_numeric($id)) {
            $this->log('edit_price: ' . $id, 'debug');
            $this->layout = 'admin';
            $this->loadModel('Price');
            $this->loadModel('Pricing_type');
            $currentPricingType = $this->Pricing_type->find('all', array('conditions' => array('Pricing_type.id' => $id)));
            $this->log($currentPricingType, 'debug');
            $currentRate = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $id), 'order' => array('Price.order' => 'ASC')));
            if (!empty($currentRate)) {
                foreach ($currentRate as $key => $value) {
                    $convertDuration = $this->secondsToTime($value['Price']['duration']);
                    $currentRate[$key]['Duration'] = $convertDuration;
                }
            }
            $this->set('currentRate', $currentRate);
            $this->set('type', $id);
            $this->set('currentPricingType', $currentPricingType[0]);
            if ($this->request->is('post') or ($this->request->is('put'))) {
                foreach ($currentRate as $oldr) {
                    $this->Price->id = $oldr['Price']['id'];
                    $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr ['Price']['id']];
                    $this->request->data['Price']['order'] = $this->request->data['Price']['order' . $oldr ['Price']['id']];
                    $this->Price->save($this->request->data);
                }
                $this->Session->setFlash($currentPricingType[0]['Pricing_type']['name'] . ' updated successfully. ', 'admin_success');
                $this->redirect(BASE_URL . 'webadmin/price/edit_price/' . $id);
            }
        } else {
            $this->redirect(BASE_URL . 'webadmin/price/');
        }

    }

    public function webadmin_update_pricing_type($id = NULL) {
        if(is_numeric($id)) {
            $this->log('update_pricing_type: ' . $id, 'debug');
            $this->layout = 'admin';
            $this->loadModel('Pricing_type');
            $this->log($_POST, 'debug');
            if ($this->request->is('post') or ($this->request->is('put'))) {
                $this->request->data['Pricing_type']['id'] = $id;
                //$this->request->data['Pricing_type']['name']
                //$this->request->data['Pricing_type']['enabled']
                $this->Pricing_type->save($this->request->data);
                $this->Session->setFlash($this->request->data['Pricing_type']['name'] . ' updated successfully. ', 'admin_success');
                $this->redirect(BASE_URL . 'webadmin/price/edit_price/' . $id);
            }
        } else {
            $this->redirect(BASE_URL . 'webadmin/');
        }

    }

    public function webadmin_add_pricing_type() {

        $this->log('add_pricing_type', 'debug');
        $this->layout = 'admin';
        $this->loadModel('Pricing_type');
        $this->log($_POST, 'debug');
        if ($this->request->is('post') or ($this->request->is('put'))) {
            $this->request->data['Pricing_type']['enabled'] = 1;
            //$this->request->data['Pricing_type']['name']
            //$this->request->data['Pricing_type']['enabled']
            $this->Pricing_type->save($this->request->data);
            $this->Session->setFlash($this->request->data['Pricing_type']['name'] . ' created successfully. ', 'admin_success');
            $this->redirect(BASE_URL . 'webadmin/price/');
        }


    }

    public function webadmin_delete_price($id = NULL) {
        /*
        $this->autoRender = FALSE;
        $this->loadModel('Price');
        $record = $this->Price->find('first', array('conditions' => array('Price.id' => $id)));
        $sub = $record['Price']['subject'];
        $this->Price->delete($id);
        $this->Session->setFlash('Price deleted Successfully.', 'admin_success');
        $this->redirect(BASE_URL . 'webadmin/price/view/' . $sub);
        */

        $prev = $_SERVER['HTTP_REFERER'];
        $this->autoRender = FALSE;
        $this->loadModel('Price');
        $this->Price->delete($id);
        $this->Session->setFlash('Price Deleted Successfully.', 'admin_success');
        $this->redirect($prev);
    }

    public function webadmin_view($sub = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $prices = $this->Price->find('all', array('conditions' => array('Price.subject' => $sub)));
        $this->set('prices', $prices);
    }

    public function webadmin_old_rate() {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $oldRate = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => '3'), 'order' => array('Price.order' => 'ASC')));
//        pr($oldRate);die;
        $this->set('oldRate', $oldRate);
        foreach ($oldRate as $kk => $vv) {
            if (!empty($vv['Price']['duration'])) {
                $oldRate[$kk]['Time'] = $this->secondsToTime($vv['Price']['duration']);
            }
        }
        $this->set('oldRate', $oldRate);
        $this->set('type', 'Old Rate');
        if ($this->request->is('post') or ( $this->request->is('put'))) {

            foreach ($oldRate as $oldr) {
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr['Price']['id']];
                $this->request->data['Price']['order'] = $this->request->data['Price']['order' . $oldr['Price']['id']];
                $this->Price->save($this->request->data);
            }
            $this->Session->setFlash('Old Rate updated successfully.', 'admin_success');
            $this->redirect(array('controller' => 'price', 'action' => 'old_rate'));
        }
    }

    public function webadmin_regular_price() {
        $this->layout = 'admin';
        $this->loadModel('Price');
      //  $this->Price->recursive = -1;
        $regularRate = $this->Price->find('all', array(
            'conditions' => array('Price.pricing_type' => '2'), 'order' => array('Price.order' => 'ASC')));
        $log = $this->Price->getDataSource()->getLog(false, false);
       // debug($log);
       // pr($regularRate);
        if (!empty($regularRate)) {
            foreach ($regularRate as $key => $value) {
                $regularRate[$key]['Time'] = $this->secondsToTime($value['Price']['duration']);
            }
        }
        $this->set('regularRate', $regularRate);
        $this->set('type', 'Regular Price');
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            foreach ($regularRate as $oldr) {
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr['Price']['id']];
                $this->request->data['Price']['order'] = $this->request->data['Price']['order' . $oldr['Price']['id']];
                $this->Price->save($this->request->data);
            }

            $this->Session->setFlash('Regular Price updated successfully. ', 'admin_success');
            $this->redirect(array('controller' => 'price', 'action' => 'regular_price'));
        }
    }

    public function webadmin_violin_price() {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $violinRate = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => '1'), 'order' => array('Price.order' => 'ASC')));
        if (!empty($violinRate)) {
            foreach ($violinRate as $key => $value) {
                $convertDuration = $this->secondsToTime($value['Price']['duration']);
                $violinRate[$key]['Duration'] = $convertDuration;
            }
        }
        $this->set('violinRate', $violinRate);
        $this->set('type', 'Violin Price');
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            foreach ($violinRate as $oldr) {
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr ['Price']['id']];
                $this->request->data['Price']['order'] = $this->request->data['Price']['order' . $oldr ['Price']['id']];
                $this->Price->save($this->request->data);
            }
            $this->Session->setFlash('Violin Price updated successfully. ', 'admin_success');
            $this->redirect(array('controller' => 'price', 'action' => 'violin_price'));
        }
    }

    public function webadmin_edit_rate($pricing_type) {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $oldRate = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $pricing_type)));
        foreach ($oldRate as $kk => $vv) {
            if (!empty($vv['Price']['duration'])) {
                $converted_time = $this->secondsToTime($vv['Price']['duration']);
                $this->set('time', $converted_time);
                $this->set('oldRate', $oldRate);
                $this->set('type', $pricing_type);
            }
        }
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            $url = $this->referer();
            foreach ($oldRate as $oldr):
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr['Price']['id']];
                $this->Price->save($this->request->data);
            endforeach;

            $this->Session->setFlash('Old Rate updated successfully.', 'admin_success');
            $this->redirect($url);
        }
    }

    public function webadmin_edit_regular($pricing_type) {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $regularRate = $this->Price->find('all', array(
            'conditions' => array('Price.pricing_type' => $pricing_type)));
        if (!empty($regularRate)) {
            foreach ($regularRate as $key => $value) {
                $regularRate[$key]['Time'] = $this->secondsToTime($value['Price'
                        ]['duration']);
            }
        }
        $this->set('regularRate', $regularRate);
        $this->set('type', $pricing_type);
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            $url = $this->referer();
            foreach ($regularRate as $oldr) {
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr['Price']['id']];
                $this->Price->save($this->request->data);
            }

            $this->Session->setFlash('Regular Price updated successfully. ', 'admin_success');
            $this->redirect($url);
        }
    }

    public function webadmin_edit_violin($pricing_type) {
        $this->layout = 'admin';
        $this->loadModel('Price');
        $violinRate = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $pricing_type)));
        if (!empty($violinRate)) {
            foreach ($violinRate as $key => $value) {
                $convertDuration = $this->secondsToTime($value['Price']['duration']);
                $violinRate[$key]['Duration'] = $convertDuration;
            }
        }
        $this->set('violinRate', $violinRate);
        $this->set('type', $pricing_type);
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            $url = $this->referer();
            foreach ($violinRate as $oldr) {
                $this->Price->id = $oldr['Price']['id'];
                $this->request->data['Price']['price'] = $this->request->data['Price']['price' . $oldr ['Price']['id']];
                $this->Price->save($this->request->data);
            }
            $this->Session->setFlash('Violin Price updated successfully. ', 'admin_success');
            $this->redirect($url);
        }
    }

    public function webadmin_delete_old_rate($id) {
        $prev = $_SERVER['HTTP_REFERER'];
        $this->autoRender = FALSE;
        $this->loadModel('Price');
        $this->Price->delete($id);
        $this->Session->setFlash('Old Rate deleted Successfully.', 'admin_success');
        $this->redirect($prev);
    }

    public function webadmin_delete_regular_rate($id) {
        $prev = $_SERVER['HTTP_REFERER'];
        $this->autoRender = FALSE;
        $this->loadModel('Price');
        $this->Price->delete($id);
        $this->Session->setFlash('Regular Price deleted Successfully.', 'admin_success');
        $this->redirect($prev);
    }

    public function webadmin_delete_violin_rate($id) {
        $prev = $_SERVER['HTTP_REFERER'];
        $this->autoRender = FALSE;
        $this->loadModel('Price');
        $this->Price->delete($id);
        $this->Session->setFlash('Violin Price deleted Successfully.', 'admin_success');
        $this->redirect($prev);
    }

    function secondsToTime($time) {
        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;
// extract hours
        $hourSeconds = $time % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);
// extract minutes
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);
// extract the remaining seconds
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);
// return the final array
        $obj = array(
//            'd' => (int) $days,
            'hour' => (int) $hours,
            'min' => (int) $minutes,
            'second' => (int) $seconds,
        );

        return $obj;
    }

}
