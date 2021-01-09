<?php

class PurchaseController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    var $uses = array('Scheduler', 'Payment', 'Payment_detail');

    public function webadmin_index() {
        $this->layout = 'admin';
        $this->loadModel('User');
        $this->loadModel('Payment');
        $all_students = $this->User->find('all', array('conditions' => array('User.role' => '1')));
        foreach ($all_students as $student) {
            $user_id[] = $student['User']['id'];
            $payment_details = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $user_id), 'order' => array('Payment.id' => 'DESC')));
            $this->set('payment_details', $payment_details);
        }
    }

    public function webadmin_assign_teacher($student_id, $id) {
        $this->layout = 'admin';
        $this->loadModel('User');
        $this->loadModel('Payment');
        $this->loadModel('Subject');
        $this->loadModel('Teacher_information');
        $this->loadModel('Teacher');
        $this->Scheduler->recursive = -1;
        $user = $this->User->find('first', array('conditions' => array('User.id' => $student_id)));
        $this->set('user', $user);
        $payment = $this->Payment->find('first', array('conditions' => array('Payment.id' => $id)));
        $this->set('payment', $payment);
        $get_teachers = $this->Teacher_information->find('all');
        foreach ($get_teachers as $all_records) {
            foreach ($all_records['Teacher'] as $all_subjects) {
                if ($payment['Payment']['subject'] == $all_subjects['subject_id']) {
                    $teacher_information_id[] = $all_subjects['teacher_information_id'];
                    $get_teacher = $this->Teacher_information->find('all', array('conditions' => array('Teacher_information.id' => $teacher_information_id)));
                    $this->set('get_teacher', $get_teacher);
                }
            }
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $teacher_id = $this->request->data['Payment']['teacher'];
            $this->Payment->id = $id;
            $this->Payment->saveField('teacher_assigned', $this->request->data['Payment']['teacher']);
            $get_data = $this->Payment->findById($id);
            $find = $this->Scheduler->find('first', array('conditions' => array('Scheduler.teacher_id' => $teacher_id, 'Scheduler.user_id' => $payment['User']['id'], 'Scheduler.subject_id' => $payment['Payment']['subject'])));
            if (!empty($find) && isset($find)) {
                $this->Scheduler->id = $find['Scheduler']['id'];
                $total_duration = $get_data['Payment']['total_time'] + $find['Scheduler']['duration'];
                $this->Scheduler->saveField('duration', $total_duration);
            } elseif (!isset($find) && empty($find)) {
                $scheduler['Scheduler']['teacher_id'] = $teacher_id;
                $scheduler['Scheduler']['user_id'] = $payment['Payment']['user_id'];
                $scheduler['Scheduler']['subject_id'] = $payment['Payment']['subject_id'];
                $scheduler['Scheduler']['duration'] = $payment['Payment']['total_time'];
                $this->Scheduler->create();
                $this->Scheduler->save($scheduler);
            }
            $this->Session->setFlash(__('Teacher assigned succesfully.'), 'admin_success');
            $this->redirect(array('controller' => 'purchase', 'action' => 'index', 'prefix' => 'webadmin'));
        }
    }

    public function webadmin_remove_teacher($id) {
        $this->autoRender = FALSE;
        $this->loadModel('Payment');
        $this->Payment->id = $id;
        $this->Payment->saveField('teacher_assigned', '');
        $this->Session->setFlash('Updated Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'purchase', 'action' => 'index', 'prefix' => 'webadmin'));
    }

    public function webadmin_make_payment($id = NULL) {
        $this->autoRender = FALSE;
        $admin = $this->Admin->findById($this->Auth->user('id'));
        $find_payment = $this->Payment->findById($id);
        $user_id = $find_payment['Payment']['user_id'];
        $payment_details = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $user_id, 'Payment_detail.account_type' => 'primary')));
        if (empty($payment_details)) {
            $payment_details = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $user_id, 'Payment_detail.account_type !=' => 'primary')));
        }
        $purchased_date = $find_payment['Payment']['payment_on'];
        $card_expiry = $payment_details['Payment_detail']['year'] . '-' . $payment_details['Payment_detail']['month'];
        if ($find_payment['Payment']['amount'] > '0.00') {
            require_once INCLUDE_PATH . 'payments/AuthorizeNet.php';
            $transaction = new AuthorizeNetAIM('99AJ26pH3rK', '89B3sbRUnFn87x6q');
            $transaction->amount = $find_payment['Payment']['amount'];
            $transaction->card_num = base64_decode($payment_details['Payment_detail']['card_number']);
            $transaction->exp_date = $card_expiry;
            $transaction->first_name = $payment_details['Payment_detail']['first_name'];
            $transaction->last_name = $payment_details['Payment_detail']['last_name'];
            $response = $transaction->authorizeAndCapture();
            if ($response->response_code == "1") {
                $paymentData = array(
                    'user_id' => $user_id,
                    'transaction_id' => $response->transaction_id,
                    'invoice_number' => $response->invoice_number,
                    'card_number' => $payment_details['Payment_detail']['card_number'],
                    'exp_month' => $payment_details['Payment_detail']['month'],
                    'exp_year' => $payment_details['Payment_detail']['year'],
                    'cvv' => $payment_details['Payment_detail']['cvv'],
                    'payment_on' => date("M-d-Y", time()),
                    'status' => '1',
                    'role' => 'paid',
                    'first_name' => $response->first_name,
                    'last_name' => $response->last_name,
                    'card_type' => $response->card_type,
                );
                $this->Payment->id = $id;

                if ($this->Payment->save($paymentData)) {
                    $subject = $find_payment['Subject']['subject'];
                    $Email = $this->getMailerForAddress($find_payment['User']['email']);
                    $Email->template('successfully_paid');
                    $Email->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'purchased_date' => $purchased_date));
                    $Email->to(array($find_payment['User']['email'] => 'lessons.info'));
                    $Email->subject('Payment Succesful.');
                    $Email->send();

                    $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                    $Email1->template('amount_paid');
                    $Email1->emailFormat('html');
                    $Email1->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'admin' => $admin, 'purchased_date' => $purchased_date));
                    $Email1->from(array('contactus@lessonsonthego.com' => 'lessons.info'));
                    $Email1->to(array($admin['Admin']['email'] => 'lessons.info'));
                    $Email1->subject('Payment Succesful.');
                    $Email1->send();
                    $url = BASE_URL . 'webadmin/student/purchases/' . $user_id;
                    $this->redirect($url);
                }
            }
        } else {
            $this->Payment->id = $id;

            $paymentData = array(
                'amount' => $find_payment['Payment']['amount'],
                'transaction_id' => '0',
                'invoice_number' => ' ',
                'card_number' => base64_encode($this->request->data['Payment']['card_number']),
                'exp_month' => $this->request->data['Payment']['month'],
                'exp_year' => $this->request->data['Payment']['year'],
                'cvv' => base64_encode($this->request->data['Payment']['cvv']),
                'payment_on' => date("M-d-Y", time()),
                'status' => '1',
                'role' => 'paid',
                'first_name' => $this->request->data['Payment']['first_name'],
                'last_name' => $this->request->data['Payment']['last_name'],
                'card_type' => $this->request->data['Payment']['card_type'],
            );
            if ($this->Payment->save($paymentData)) {
                $subject = $find_payment['Subject']['subject'];
                $Email = $this->getMailerForAddress($find_payment['User']['email']);
                $Email->template('successfully_paid');
                $Email->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'purchased_date' => $purchased_date));
                $Email->to(array($find_payment['User']['email'] => 'lessons.info'));
                $Email->subject('Payment Succesful.');
                $Email->send();

                $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                $Email1->template('amount_paid');
                $Email1->emailFormat('html');
                $Email1->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'admin' => $admin, 'purchased_date' => $purchased_date));
                $Email1->from(array('contactus@lessonsthego.com' => 'lessons.info'));
                $Email1->to(array($admin['Admin']['email'] => 'lessons.info'));
                $Email1->subject('Payment Succesful.');
                $Email1->send();
                $url = BASE_URL . 'webadmin/student/purchases/' . $user_id;
                $this->redirect($url);
            }
        }
    }

    public function webadmin_payment($id = NULL) {
        $this->layout = 'admin';
        $admin = $this->Admin->findById($this->Auth->user('id'));
        $find_payment = $this->Payment->findById($id);
        $user_id = $find_payment['Payment']['user_id'];
        $payment_detail = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.account_type' => 'primary')));

        if (empty($payment_detail)) {
            $payment_detail = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.account_type !=' => 'primary')));
        }
        $this->set('payment_detail', $payment_detail);
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $amount = $this->request->data['Payment']['amount'];
            $purchased_date = date('Y-m-d');
            $card_expiry = $data['Payment']['year'] . '-' . $data['Payment']['month'];
            if ($amount > '0') {
                require_once INCLUDE_PATH . 'payments/AuthorizeNet.php';
                $transaction = new AuthorizeNetAIM('99AJ26pH3rK', '89B3sbRUnFn87x6q');
                $transaction->amount = $amount;
                $transaction->card_num = $data['Payment']['card_number'];
                $transaction->exp_date = $card_expiry;
                $transaction->first_name = $data['Payment']['first_name'];
                $transaction->last_name = $data['Payment']['last_name'];
                $response = $transaction->authorizeAndCapture();
                if ($response->response_code == "1") {
                    $paymentData = array(
                        'user_id' => $user_id,
                        'amount' => $amount,
                        'transaction_id' => $response->transaction_id,
                        'invoice_number' => $response->invoice_number,
                        'card_number' => base64_encode($data['Payment']['card_number']),
                        'exp_month' => $data['Payment']['month'],
                        'exp_year' => $data['Payment']['year'],
                        'cvv' => base64_encode($data['Payment']['cvv']),
                        'payment_on' => date("M-d-Y", time()),
                        'status' => '1',
                        'role' => 'paid',
                        'first_name' => $response->first_name,
                        'last_name' => $response->last_name,
                        'card_type' => $response->card_type,
                    );
                    $this->Payment->id = $id;

                    if ($this->Payment->save($paymentData)) {
                        $subject = $find_payment['Subject']['subject'];
                        $Email = $this->getMailerForAddress($find_payment['User']['email']);
                        $Email->template('successfully_paid');
                        $Email->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'purchased_date' => $purchased_date));
                        $Email->to(array($find_payment['User']['email'] => 'lessons.info'));
                        $Email->subject('Payment Succesful.');
                        $Email->send();

                        $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                        $Email1->template('amount_paid');
                        $Email1->emailFormat('html');
                        $Email1->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'admin' => $admin, 'purchased_date' => $purchased_date));
                        $Email1->from(array('contactus@lessonsonthego.com' => 'lessons.info'));
                        $Email1->to(array($admin['Admin']['email'] => 'lessons.info'));
                        $Email1->subject('Payment Succesful.');
                        $Email1->send();
                        $this->redirect(array('controller' => 'student', 'action' => 'purchases/' . $user_id, 'prefix' => 'webadmin'));
                    }
                }
            } else {
                $this->Payment->id = $id;

                $paymentData = array(
                    'amount' => $amount,
                    'transaction_id' => '0',
                    'invoice_number' => '',
                    'card_number' => base64_encode($this->request->data['Payment']['card_number']),
                    'exp_month' => $this->request->data['Payment']['month'],
                    'exp_year' => $this->request->data['Payment']['year'],
                    'cvv' => base64_encode($this->request->data['Payment']['cvv']),
                    'payment_on' => date("M-d-Y", time()),
                    'status' => '1',
                    'role' => 'paid',
                    'first_name' => $this->request->data['Payment']['first_name'],
                    'last_name' => $this->request->data['Payment']['last_name'],
                    'card_type' => $this->request->data['Payment']['card_type'],
                );
                if ($this->Payment->save($paymentData)) {
                    $subject = $find_payment['Subject']['subject'];
                    $Email = $this->getMailerForAddress($find_payment['User']['email']);
                    $Email->template('successfully_paid');
                    $Email->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'purchased_date' => $purchased_date));
                    $Email->to(array($find_payment['User']['email'] => 'lessons.info'));
                    $Email->subject('Payment Succesful.');
                    $Email->send();

                    $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                    $Email1->template('amount_paid');
                    $Email1->emailFormat('html');
                    $Email1->viewVars(array('subject' => $subject, 'paymentData' => $paymentData, 'user_details' => $find_payment, 'admin' => $admin, 'purchased_date' => $purchased_date));
                    $Email1->from(array('contactus@lessonsonthego.com' => 'lessons.info'));
                    $Email1->to(array($admin['Admin']['email'] => 'lessons.info'));
                    $Email1->subject('Payment Succesful.');
                    $Email1->send();
                    $this->redirect(array('controller' => 'student', 'action' => 'purchases/' . $user_id, 'prefix' => 'webadmin'));
                }
            }
        }
    }

}
