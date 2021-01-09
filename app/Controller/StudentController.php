<?php

class StudentController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $authUser = $this->Auth->User();

        if (isset($authUser['role']) && ($authUser['role'] == '2')) {
            $this->redirect(BASE_URL);
        }
    }

    var $uses = array('Scheduler', 'Calendar', 'User', 'Payment', 'Message', 'Payment_detail', 'Subject', 'Price', 'Teacher_information', 'Teacher', 'Assigned_teacher', 'Coupon', 'Total_hour', 'Pack', 'Voilin_hour', 'Admin', 'Email_content', 'Child_user', 'Email_duration', 'Authorize', 'Duration');

//generate an random string of 6 characters.
    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

// add student.
    public function webadmin_add() {
        $this->layout = 'admin';
        $this->loadModel('User');
        $this->loadModel('Pricing_type');
        $all_subjects = $this->Subject->find('all', array('order' => array('Subject.order' => 'ASC')));
        $this->set('all_subjects', $all_subjects);
        $pricing_types = $this->Pricing_type->find('all', array('conditions' => array('Pricing_type.enabled' => 1), 'order' => array('Pricing_type.id' => 'DESC')));
        $this->set('pricing_types', $pricing_types);
        $email_data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Student Signup')));
        if ($this->request->is('post')) {
            $credit_hours = $this->request->data['User']['credit_hour'];
            $credit_mints = $this->request->data['User']['credit_minute'];

            if (!empty($credit_hours) && !empty($credit_mints)) {
                $convert_hour = $credit_hours * 60;
                $total_time = $convert_hour + $credit_mints;
            } elseif (!empty($credit_hours) && empty($credit_mints)) {
                $convert_hour = $credit_hours * 60;
                $total_time = $convert_hour;
            } elseif (empty($credit_hours) && !empty($credit_mints)) {
                $total_time = $credit_mints;
            } else {
                $total_time = '';
            }

            if ($this->request->data['User']['voilin_price'] == 'Yes') {
                $voilin_hours = $this->request->data['User']['voilin_hour'];
                $voilin_mints = $this->request->data['User']['voilin_minute'];

                if (!empty($voilin_hours) && !empty($voilin_mints)) {
                    $convert_hour = $voilin_hours * 60;
                    $voilin_time = $convert_hour + $voilin_mints;
                } elseif (!empty($voilin_hours) && empty($voilin_mints)) {
                    $convert_hour = $voilin_hours * 60;
                    $voilin_time = $convert_hour;
                } elseif (empty($voilin_hours) && !empty($voilin_mints)) {
                    $voilin_time = $voilin_mints;
                } else {
                    $voilin_time = '';
                }
            } else {
                $voilin_time = '';
            }


            $posted_email = $this->request->data['User']['email'];
            $find_record = $this->User->find('first', array('conditions' => array('User.email' => $posted_email)));
            if ($this->User->validates()) {
                $this->request->data['User']['role'] = '1';
                $pwd = $this->generateRandomString();
                $password = AuthComponent::password($pwd);
                $this->request->data['User']['password'] = $password;
                if (!empty($total_time)) {
                    $this->request->data['User']['total_time'] = $total_time;
                }
                if (!empty($voilin_time)) {
                    $this->request->data['User']['voilin_time'] = $voilin_time;
                }
                if ($this->User->save($this->request->data)) {
                    $id = $this->User->getLastInsertID();
                    if (!empty($this->request->data['Child_user'])) {
                        for ($i = 0; $i < count($this->request->data['Child_user']['firstname']); $i++) {
                            $child_user['Child_user']['user_id'] = $id;
                            $child_user['Child_user']['firstname'] = $this->request->data['Child_user']['firstname'][$i];
                            $child_user['Child_user']['lastname'] = $this->request->data['Child_user']['lastname'][$i];
                            $child_user['Child_user']['age'] = $this->request->data['Child_user']['age'][$i];
                            $child_user['Child_user']['subject'] = $this->request->data['Child_user']['subject'][$i];
                            $this->Child_user->create();
                            $this->Child_user->save($child_user);
                        }
                    }

                    $hour = 0;
                    $minutes = 0;


                    if (!empty($total_time)) {
                        $total_time = 0;
                        $credit_hours = 0;
                        $credit_mints = 0;
                    }
                    $this->Total_hour->create();
                    $save['Total_hour']['student_id'] = $id;
                    $save['Total_hour']['total_time'] = $total_time;
                    $this->Total_hour->save($save);

                    $hour = $credit_hours;
                    $minutes = $credit_mints;


                    if ($this->request->data['User']['voilin_price'] == 'Yes') {
                        if (!empty($voilin_time)) {
                            $voilin_time = 0;
                            $voilin_hours = 0;
                            $voilin_mints = 0;
                        }
                        $this->Voilin_hour->create();
                        $voilin['Voilin_hour']['student_id'] = $id;
                        $voilin['Voilin_hour']['total_time'] = $voilin_time;
                        $this->Voilin_hour->save($voilin);

                        $hour += $voilin_hours;
                        $minutes += $voilin_mints;

                    }


                    if(!empty($total_time) || !empty($vioin_time)) {
                        $this->loadModel('Payment');
                        $payment['Payment']['user_id'] = $id;
                        $payment['Payment']['amount'] = 0.0;
                        $payment['Payment']['transaction_id'] = 0;
                        $payment['Payment']['invoice_number'] = 0;
                        $payment['Payment']['card_number'] = 0;
                        $payment['Payment']['exp_month'] = 0;
                        $payment['Payment']['exp_year'] = 0;
                        $payment['Payment']['cvv'] = 0;
                        $payment['Payment']['first_name'] = 'Admin';
                        $payment['Payment']['last_name'] = ' ';
                        $payment['Payment']['card_type'] = 'Credit';
                        $payment['Payment']['card_image'] = ' ';
                        $payment['Payment']['notes'] = ' ';
                        $payment['Payment']['subject'] = 0;
                        $payment['Payment']['subject_id'] = 0;
                        $payment['Payment']['subject_name'] = 'Credit';
                        $payment['Payment']['pack'] = 0;
                        $payment['Payment']['pack_name'] = 'Initial Credit';
                        $payment['Payment']['quantity'] = 1;
                        $payment['Payment']['role'] = 'paid';
                        $payment['Payment']['status'] = 2;
                        $payment['Payment']['payment_on'] = date("m/d/Y", time());

                        $payment['Payment']['duration'] = "";
                        $timeValue = 0;

                        if(!empty($hour))  {
                            $payment['Payment']['duration'] = $hour." hour";
                            $timeValue = $hour * 60;
                            if($hour > 0)  $payment['Payment']['duration'] .= "s";
                            if(!empty($minutes)) $payment['Payment']['duration'] .= " ";
                        }
                        if(!empty($minutes))  {
                            $payment['Payment']['duration'] .= $minutes." minutes";
                            $timeValue += $minutes;
                        }

                        $payment['Payment']['total_time'] = $timeValue;
                        $payment['Payment']['left_time'] = $timeValue;

                        $this->Payment->save($payment);

                    }
                    $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
                    $Email = $this->getMailerForAddress($this->request->data['User']['email']);
                    $Email->template('student_signup');
                    $Email->emailFormat('both');
                    $Email->viewVars(array('user' => $user, 'passwords' => $pwd, 'data' => $email_data));
                    $Email->to($this->request->data['User']['email'], $user['User']['first_name']." ".$user['User']['last_name']);
                    $Email->subject('Successful Sign Up');
                    $Email->send();
                    $this->Session->setFlash('Student added Successfully', 'admin_success');
                    $url = BASE_URL . 'webadmin/student/add_card/' . $id;
                    $this->redirect($url);
                }
            } else {
                $errors = $this->User->validationErrors;
            }
        }
    }

//manage added students
    public function webadmin_index() {
        $this->layout = 'admin';
        $find_students = $this->User->find('all', array('conditions' => array('User.role' => '1'), 'order' => array('User.last_name' => 'ASC')));
        //pr($find_students);
        //   die;
        $all_subjects = $this->Subject->find('all');
        if (!empty($all_subjects)) {
            $this->set('all_subjects', $all_subjects);
        }

        if (!empty($find_students)) {
            foreach ($find_students as $key => $value) {
                $student_id = $value['User']['id'];
                $total_hr = $this->Total_hour->findByStudentId($student_id);
                if (!empty($total_hr['Total_hour']) && isset($total_hr['Total_hour'])) {
                    $find_students[$key]['Total_hour'] = $total_hr['Total_hour'];
                }
            }

            $this->set('find_student', $find_students);
        }
    }

// delete an existing student.
    public function webadmin_delete_student($id = NULL) {
        $this->autoRender = FALSE;
        $this->loadModel('User');
        $this->User->delete($id);
        $this->Session->setFlash('Student deleted Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
    }

// edit an student
    public function webadmin_edit_student($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('User');
        $student = $this->User->find('first', array('conditions' => array('User.id' => $id)));

        $this->loadModel('Pricing_type');
        $pricing_types = $this->Pricing_type->find('all', array('conditions' => array('Pricing_type.enabled' => 1), 'order' => array('Pricing_type.id' => 'DESC')));
        $this->set('pricing_types', $pricing_types);

        $get_total = $this->Total_hour->findByStudentId($id);


        if (!empty($get_total['Total_hour'])) {
            $convert_time = $this->secondsToTime($get_total['Total_hour']['total_time']);

            if (!empty($convert_time['min']) && !empty($convert_time['second']) && ($convert_time['hour'] == '-1')) {
                $hrs = $convert_time['min'] + 1;
                $student['Total_hour']['hour'] = $hrs;
                $student['Total_hour']['minutes'] = $convert_time['second'];
            } elseif (!empty($convert_time['min']) && !empty($convert_time['second'])) {
                $student['Total_hour']['hour'] = $convert_time['min'];
                $student['Total_hour']['minutes'] = $convert_time['second'];
            } elseif (!empty($convert_time['min']) && empty($convert_time['second'])) {
                $student['Total_hour']['hour'] = $convert_time['min'];
            } elseif (empty($convert_time['min']) && !empty($convert_time['second'])) {
                $student['Total_hour']['minutes'] = $convert_time['second'];
            }
        }

        $get_voilin = $this->Voilin_hour->findByStudentId($id);
        if (!empty($get_voilin['Voilin_hour'])) {
            $convert_for_voilin = $this->secondsToTime($get_voilin['Voilin_hour']['total_time']);
            if (!empty($convert_for_voilin['min']) && !empty($convert_for_voilin['second'])) {
                $student['Voilin_hour']['voilin_hour'] = $convert_for_voilin['min'];
                $student['Voilin_hour']['voilin_minute'] = $convert_for_voilin['second'];
            } elseif (!empty($convert_for_voilin['min']) && empty($convert_for_voilin['second'])) {
                $student['Voilin_hour']['voilin_hour'] = $convert_for_voilin['min'];
            } elseif (empty($convert_for_voilin['min']) && !empty($convert_for_voilin['second'])) {
                $student['Voilin_hour']['voilin_minute'] = $convert_for_voilin['second'];
            }
        }
//Additional Children
        $this->Child_user->recursive = -1;
        $find_children = $this->Child_user->find('all', array('conditions' => array('Child_user.user_id' => $id)));
        $this->set('find_children', $find_children);
        $all_subjects = $this->Subject->find('all');
        $this->set('all_subjects', $all_subjects);
//Additional Children

        if ($this->request->is('post') or ( $this->request->is('put'))) {
            if ($this->User->validates()) {

                $this->User->id = $id;

                if ($this->request->data['User']['voilin_price'] == 'No') {
                    $this->request->data['User']['violin_second'] = '';
                    $this->request->data['User']['violin_last'] = '';
                }
                if ($this->User->save($this->request->data)) {

                    if (!empty($this->request->data['Child_user']['firstname'][0])) {
                        $count_child = count($this->request->data['Child_user']['firstname']);
                        $this->Child_user->deleteAll(array('Child_user.user_id' => $id), false);
                        for ($i = 0; $i < $count_child; $i++) {
                            $create_child['Child_user']['user_id'] = $id;
                            $create_child['Child_user']['firstname'] = $this->request->data['Child_user']['firstname'][$i];
                            $create_child['Child_user']['lastname'] = $this->request->data['Child_user']['lastname'][$i];
                            $create_child['Child_user']['age'] = $this->request->data['Child_user']['age'][$i];
                            $create_child['Child_user']['subject'] = $this->request->data['Child_user']['subject'][$i];
                            $this->Child_user->create();
                            $this->Child_user->save($create_child);
                        }
                    }

                    $this->Session->setFlash(__('Student edited successfully.'), 'admin_success');
                    return $this->redirect(array('action' => 'index'));
                }
            }
        } else {
            $errors = $this->User->validationErrors;
        }
        if (empty($this->request->data)) {
            $this->set('student', $student);
        }
        if (!empty($student['User']['credit'])) {
            $credits = $student['User']['credit'] . ' Minutes';
        } else {
            $credits = '-';
        }
        $this->set('credits', $credits);
        $this->set('student', $student);
    }

// change status of the existing student 
    public function webadmin_change_status($id = NULL, $status = NULL) {
//        echo $id;
//        echo $status;
//        die;
        $this->loadModel('User');
        $iduser = $this->User->findById($id);
        if ($iduser['User']['status'] == '0') {
            $this->User->updateAll(array('User.status' => "1"), array('User.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->User->updateAll(array('User.status' => "0"), array('User.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        return $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
    }

// dashboard or index page of the student after login
    public function index() {
        $student = $this->Auth->user();
        $this->layout = 'student';
        $this->loadModel('User');
        $this->loadModel('Payment');
        $this->loadModel('Payment_detail');
        $this->Calendar->recursive = -1;

        $id = $student['id'];
        $studentinfo = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $this->set('studentinfo', $studentinfo);

        $transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $id)));
        $this->set('transactions', $transactions);

        $payment_detail = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $id)));
        $this->set('payment_detail', $payment_detail);
        $calendar = $this->Calendar->find('all', array('conditions' => array('Calendar.user_id' => $id, 'Calendar.deleted !=' => 'yes')));
        foreach ($calendar as $cal) {
            $Dates[] = $cal['Calendar']['start_date'];
        }
        if (!empty($Dates)) {
            $close_date = current($Dates);
            foreach ($Dates as $date) {
                if (abs(strtotime(date('Y-m-d')) - strtotime($date)) < abs(strtotime(date('Y-m-d')) - strtotime($close_date))) {
                    $close_date = $date;
                }
            }
            if (strtotime($close_date) > strtotime(date('Y-m-d'))) {
                $get_data = $this->Calendar->find('first', array('conditions' => array('Calendar.user_id' => $id, 'Calendar.start_date' => $close_date)));
                if (!empty($get_data) && isset($get_data)) {
                    $this->set('get_data', $get_data);
                    $find_teacher = $this->User->find('first', array('conditions' => array('User.id' => $get_data['Calendar']['teacher_id'])));
                    $this->set('find_teacher', $find_teacher);
                }
            }
        }

//Lessons and Credits
        $other_transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $id, 'Payment.subject !=' => '11')));
        if (!empty($other_transactions)) {
            $exact_total = 0;
            foreach ($other_transactions as $all) {
                $exact_total += $all['Payment']['total_time'];
            }
            $other_purchased = $this->secondsToTime($exact_total);
            $this->set('other_purchased', $other_purchased);
        }

        $total_hours = $this->Total_hour->findByStudentId($id);

        if (!empty($total_hours)) {
            if (!empty($total_hours['Total_hour']['total_time']) && isset($total_hours['Total_hour']['total_time'])) {
                $converted_total = $this->secondsToTime($total_hours['Total_hour']['total_time']);

                $this->set('converted_total', $converted_total);
            }
            if (!empty($total_hours['Total_hour']['credits']) && isset($total_hours['Total_hour']['credits'])) {
                if ($total_hours['Total_hour']['credits'] > '0') {
                    $converted_credits = $this->secondsToTime($total_hours['Total_hour']['credits']);
                    $this->set('converted_credits', $converted_credits);
                } else {
                    if (abs($total_hours['Total_hour']['credits']) > '60') {
                        $converted_credits_negative = $this->secondsToTime($total_hours['Total_hour']['credits']);
                    } else {
                        $converted_credits_negative['second'] = $total_hours['Total_hour']['credits'];
                    }
                    $this->set('converted_credits_negative', $converted_credits_negative);
                }
            }
        }

        $violin_transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $id, 'Payment.subject' => '11')));
        if (!empty($violin_transactions)) {
            $total_time = 0;
            foreach ($violin_transactions as $v_all) {
                $total_time += $v_all['Payment']['total_time'];
            }
            $violin_purchased = $this->secondsToTime($total_time);
            $this->set('violin_purchased', $violin_purchased);
        }

        $violin_hours = $this->Voilin_hour->findByStudentId($id);
        if (!empty($violin_hours)) {
            if (!empty($violin_hours['Voilin_hour']['total_time']) && isset($violin_hours['Voilin_hour']['total_time'])) {
                $converted_total1 = $this->secondsToTime($violin_hours['Voilin_hour']['total_time']);
                $this->set('converted_total1', $converted_total1);
            }
            if (!empty($violin_hours['Voilin_hour']['credits']) && isset($violin_hours['Voilin_hour']['credits'])) {
                if ($violin_hours['Voilin_hour']['credits'] > '0') {
                    $converted_credits1 = $this->secondsToTime($violin_hours['Voilin_hour']['credits']);
                    $this->set('converted_credits1', $converted_credits1);
                } else {
                    if (abs($violin_hours['Voilin_hour']['credits']) > '60') {
                        $converted_credits_negative1 = $this->secondsToTime($violin_hours['Voilin_hour']['credits']);
                    } else {
                        $converted_credits_negative1['second'] = $violin_hours['Voilin_hour']['credits'];
                    }
                    $this->set('converted_credits_negative1', $converted_credits_negative1);
                }
            }
        }
    }

// student logout on front
    public function logout() {
        session_destroy();
        return $this->redirect($this->Auth->logout());
    }

// profile of student at frontend
    public function my_info() {
        $this->layout = 'student';
        $this->loadModel('User');
        $this->loadModel('Admin');
        $authUser = $this->Auth->user();
        $id = $authUser['id'];

        $student = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $admin = $this->Admin->find('first');

//additional student start
        $all_subjects = $this->Subject->find('all');
        $this->set('all_subjects', $all_subjects);
        $this->Child_user->recursive = -1;
        $additional = $this->Child_user->find('all', array('conditions' => array('Child_user.user_id' => $id)));
        $this->set('additional', $additional);
//additional student end

        if ($this->request->is('put') || $this->request->is('post')) {
            if ($this->User->validates()) {
                $this->User->id = $id;
                if (!empty($this->request->data['User']['image']['name'])) {
                    $image = $this->request->data['User']['image'];
                    $file = time() . '_' . $image['name'];
                    move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/student_images/' . $file);
                    $this->request->data['User']['image'] = $file;
                } else {
                    $this->request->data['User']['image'] = $student['User']['image'];
                }
                if ($this->User->save($this->request->data, array('validate' => FALSE))) {
                    $student_details = $student;
                    $Email = $this->getMailerForAddress($admin['Admin']['email']);
                    $Email->template('student_profile_updated');
                    $Email->emailFormat('html');
                    $Email->viewVars(array('student_details' => $student_details, 'admin' => $admin));
                    $Email->from(array($student_details['User']['email'] => $student_details['User']['student_firstname'] . ' ' . $student_details['User']['student_lastname']));
                    $Email->to($admin['Admin']['email']);
                    $Email->subject('Student Profile Updated.');
                    $Email->send();

                    if (isset($this->request->data['Child_user']) && !empty($this->request->data['Child_user'])) {
                        $count_child = count($this->request->data['Child_user']['firstname']);
                        $this->Child_user->deleteAll(array('Child_user.user_id' => $id), false);
                        for ($i = 0; $i < $count_child; $i++) {
                            if (!empty($this->request->data['Child_user']['firstname'][$i]) && !empty($this->request->data['Child_user']['lastname'][$i]) && !empty($this->request->data['Child_user']['age'][$i]) && !empty($this->request->data['Child_user']['subject'][$i])) {
                                $create_child['Child_user']['user_id'] = $id;
                                $create_child['Child_user']['firstname'] = $this->request->data['Child_user']['firstname'][$i];
                                $create_child['Child_user']['lastname'] = $this->request->data['Child_user']['lastname'][$i];
                                $create_child['Child_user']['age'] = $this->request->data['Child_user']['age'][$i];
                                $create_child['Child_user']['subject'] = $this->request->data['Child_user']['subject'][$i];
                                $this->Child_user->create();
                                $this->Child_user->save($create_child);
                            } else {
                                $this->Session->setFlash(__('All fields are required for Additional Students.'), 'error');
                            }
                        }
                    }
                    $this->Session->setFlash(__('Students details saved successfully.'), 'success');
                    $this->redirect(array('action' => 'my_info'));
                }
            } else {
                $errors = $this->User->validationErrors;
            }
        }

        $this->set('student', $student);
    }

// messages for student at frontend
    public function messages() {
        $this->layout = 'student';
        $all_message = $this->Message->find('all', array('group' => array('Message.send_by'), 'order' => array('Message.id' => 'DESC'), 'conditions' => array('Message.send_to' => $this->Auth->User('id'))));


        if (empty($all_message)) {
            $all_message = $this->Message->find('all', array('group' => array('Message.send_to'), 'order' => array('Message.id' => 'DESC'), 'conditions' => array('Message.send_by' => $this->Auth->User('id'))));
        }


        if (!empty($all_message)) {
            foreach ($all_message as $keyy => $msgs) {
                $sender_id = $msgs['Message']['send_by'];
                $reciever_id = $msgs['Message']['send_to'];
                $messages = $this->Message->find('all', array(
                    'conditions' => array(
                        'OR' => array(
                            array(
                                'Message.send_by' => $sender_id, 'Message.send_to' => $reciever_id),
                            array('Message.send_to' => $sender_id, 'Message.send_by' => $reciever_id),
                        )
                    ),
                    'order' => array('Message.id' => 'DESC')
                ));
                $msg_count = $this->Message->find('count', array('conditions' => array('Message.message_status' => 'unread', 'Message.send_to' => $sender_id)));
                $v = $messages[0];
                if ($v['Message']['send_to'] != $this->Auth->User('id')) {
                    $user = $this->User->findById($v['Message']['send_to']);
                    $all_message[$keyy]['User'] = $user['User'];
                } else {
                    $user = $this->User->findById($v['Message']['send_by']);
                    $all_message[$keyy]['User'] = $user['User'];
                }
                $all_message[$keyy]['Message'] = $v['Message'];
                $all_message[$keyy]['Count'] = $msg_count;
            }
        }
        if (isset($all_message) && !empty($all_message)) {
            $this->set('all_message', $all_message);
        }

        $teacher = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.student_id' => $this->Auth->user('id'), 'Assigned_teacher.status' => '1')));
        if (!empty($teacher)) {
            foreach ($teacher as $teaches) {
                $teacher_id = $teaches['Assigned_teacher']['teacher_id'];
                $teach[] = $this->User->findById($teacher_id);
            }
            $this->set('teacher', $teach);
        }
    }

// paymnets done by the student
    public function payments() {
        $this->log("on payments page", 'debug');
        $this->layout = 'student';
        $this->loadModel('Payment_detail');
        $this->loadModel('User');
        $user = $this->Auth->user('id');
        $student = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $user)));
        $this->set('student', $student);
        $get_user = $this->User->findById($user);

        if (empty($student)) {

            if ($this->request->is('post')) {

                if ($this->Payment_detail->validates()) {

                    if ($this->request->data['Payment_detail']['billing_address'] == 'same') {
                        $this->request->data['Payment_detail']['address'] = $get_user['User']['address'];
                        $this->request->data['Payment_detail']['apartment'] = $get_user['User']['suite'];
                        $this->request->data['Payment_detail']['city'] = $get_user['User']['city'];
                        $this->request->data['Payment_detail']['state'] = $get_user['User']['state'];
                        $this->request->data['Payment_detail']['zip_code'] = $get_user['User']['zip_code'];
                    }


                    $this->request->data['Payment_detail']['student_id'] = $user;
                    $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                    $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                    if ($this->request->data['Payment_detail']['account_type'] == 1) {
                        $this->request->data['Payment_detail']['account_type'] = 'primary';
                    } elseif ($this->request->data['Payment_detail']['account_type'] == 0) {
                        $already_primary = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.account_type' => 'primary', 'Payment_detail.student_id' => $user)));
                        if (empty($already_primary)) {
                            $this->request->data['Payment_detail']['account_type'] = 'primary';
                        }
                    }

                    //$verifyCard = $this->verifyCardDetails($this->request->data, $get_user);
                    //$this->log($verifyCard, 'debug');
                    $verifyCard=1;


                    if($verifyCard===1) {
                        if ($this->Payment_detail->save($this->request->data)) {
                            $this->Session->setFlash(__('Credit Card Details added succesfully.'), 'success');
                            $this->redirect(array('controller' => 'student', 'action' => 'payments'));
                        } else {
                            $this->Session->setFlash(__('There was an error saving your card: '.$verifyCard), 'error');
                            $this->redirect(array('controller' => 'student', 'action' => 'payments'));
                        }
                    } else {
                        $this->Session->setFlash(__('There was an error validating your card: '.$verifyCard), 'error');
                        $this->redirect(array('controller' => 'student', 'action' => 'payments'));
                    }
                }
            } else {
                $errors = $this->Payment_detail->validationErrors;
            }
        } else {

            for ($i = 1; $i <= count($student); $i++) {
                if ($this->request->is('put') || ($this->request->is('post'))) {
                    $user_detail = $this->User->findById($user);
                    $save_data = $this->request->data;
                    $data_id = @$save_data['Payment_detail']['id'];
                    if (isset($data_id)) {
                        $find = $this->Payment_detail->findById($save_data['Payment_detail']['id']);
                        //$this->log("WTF!?!?", 'debug');
                        $get_account_pos = strrpos($this->request->data['Payment_detail']['card_number'], '*');
                        $get_cvv_pos = strrpos($this->request->data['Payment_detail']['cvv'], '*');
                        if (isset($get_account_pos) && $get_account_pos != '') {
                            $save_data['Payment_detail']['card_number'] = $find['Payment_detail']['card_number'];
                            //FOR VERIFICATION
                            //$this->request->data['Payment_detail']['card_number'] = ($find['Payment_detail']['card_number']);
                        } else {
                            $save_data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                        }

                        if (isset($get_cvv_pos) && $get_cvv_pos != '') {
                            $save_data['Payment_detail']['cvv'] = $find['Payment_detail']['cvv'];
                        } else {
                            $save_data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                            //FOR VERIFICATION
                            //$this->request->data['Payment_detail']['cvv'] = ($find['Payment_detail']['cvv']);
                        }

                        if (($save_data['Payment_detail']['account_type'] == '1') || ($save_data['Payment_detail']['account_type'] == 'on')) {
                            $save_data['Payment_detail']['account_type'] = 'primary';
                            $find_all = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $find['Payment_detail']['student_id'], 'Payment_detail.account_type' => 'primary')));
                            if (!empty($find_all) && isset($find_all)) {
                                $get_id = $find_all['Payment_detail']['id'];
                                $find_all['Payment_detail']['account_type'] = 'secondary';

                                $this->Payment_detail->id = $get_id;
                                $this->Payment_detail->saveField('account_type', $find_all['Payment_detail']['account_type']);
                            }
                        } elseif ($save_data['Payment_detail']['account_type'] == 0) {
                            $save_data['Payment_detail']['account_type'] = 'secondary';
                        }

                        $id = $this->request->data['Payment_detail']['id'];



                        $this->Payment_detail->id = $id;


                        //$verifyCard = $this->verifyCardDetails($this->request->data, $get_user);
                        //$this->log($verifyCard, 'debug');
                        $verifyCard=1; //DISABLED CARD VALIDATION

                        if($verifyCard==1) {
                            if ($this->Payment_detail->save($save_data)) {
                                $this->Session->setFlash(__('Credit Card details updated successfully.'), 'success');
                                $this->redirect(array('action' => 'payments'));
                            }
                        } else {
                            $this->Session->setFlash(__('There was an error validating your card: '.$verifyCard), 'error');
                            $this->redirect(array('controller' => 'student', 'action' => 'payments'));
                        }
                    } else {
                        $create_data['Payment_detail']['student_id'] = $user;
                        $create_data['Payment_detail']['name_on_card'] = $this->request->data['Payment_detail']['name_on_card'];
                        $create_data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                        $create_data['Payment_detail']['card_type'] = $this->request->data['Payment_detail']['card_type'];
                        $create_data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                        $create_data['Payment_detail']['month'] = $this->request->data['Payment_detail']['month'];
                        $create_data['Payment_detail']['year'] = $this->request->data['Payment_detail']['year'];
                        $create_data['Payment_detail']['first_name'] = $this->request->data['Payment_detail']['first_name'];
                        $create_data['Payment_detail']['last_name'] = $this->request->data['Payment_detail']['last_name'];


                        if (isset($this->request->data['Payment_detail']['account_type']) && ($this->request->data['Payment_detail']['account_type'] == 1)) {
                            $create_data['Payment_detail']['account_type'] = 'primary';
                        } elseif (isset($this->request->data['Payment_detail']['account_type']) && ($this->request->data['Payment_detail']['account_type'] == 0)) {
                            $create_data['Payment_detail']['account_type'] = 'secondary';
                        } else {
                            $create_data['Payment_detail']['account_type'] = 'secondary';
                        }


                        if ($this->request->data['Payment_detail']['billing_address'] == 'same') {
                            $create_data['Payment_detail']['address'] = $user_detail['User']['address'];
                            $create_data['Payment_detail']['apartment'] = $user_detail['User']['suite'];
                            $create_data['Payment_detail']['city'] = $user_detail['User']['city'];
                            $create_data['Payment_detail']['state'] = $user_detail['User']['state'];
                            $create_data['Payment_detail']['zip_code'] = $user_detail['User']['zip_code'];
                        }


                        //$verifyCard = $this->verifyCardDetails($this->request->data, $get_user);
                        //$this->log($verifyCard, 'debug');
                        $verifyCard=1;

                        if($verifyCard==1) {
                            $this->Payment_detail->create();
                            if ($this->Payment_detail->save($create_data)) {
                                $this->Session->setFlash(__('Credit card Details added succesfully.'), 'success');
                                $this->redirect(array('action' => 'payments'));
                            }
                        } else {
                            $this->Session->setFlash(__('There was an error validating your card: '.$verifyCard), 'error');
                            $this->redirect(array('controller' => 'student', 'action' => 'payments'));
                        }
                    }
                } else {
                    $errors = $this->Payment_detail->validationErrors;
                }
            }
        }
    }

    public function delete_card_detail($id = null) {
        $this->autoRender = FALSE;

        $this->loadModel('Payment_detail');
        $this->loadModel('User');
        $user = $this->Auth->user('id');
        $payment_details = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $user)));

        $cardToDelete = $this->Payment_detail->findById($id);

        $this->log($payment_details, 'debug');
        $this->log($cardToDelete, 'debug');

        $this->log(sizeof($payment_details), 'debug');

        if(sizeof($payment_details) < 2 ) {
            $this->log("fewer than 2 cards, do not delete", 'debug');
            $this->Session->setFlash('Card cannot be deleted. You must have at least one card in your account.', 'success');
            $this->redirect(array('action' => 'payments'));
        } else if(sizeof($payment_details) > 1) {
            if($cardToDelete['Payment_detail']['account_type'] == 'secondary') {
                $this->log("2 cards, card to delete is secondary, delete it", 'debug');
                $this->Payment_detail->delete($id);
                $this->Session->setFlash('Card Detail deleted Successfully.', 'success');
                $this->redirect(array('action' => 'payments'));
            } else if($cardToDelete['Payment_detail']['account_type'] == 'primary') {
                $this->log("2 cards, card to delete is primary", 'debug');
                for($i = 0; $i < sizeof($payment_details);$i++) {
                    if($payment_details[$i]['Payment_detail']['id'] != $id &&
                        $payment_details[$i]['Payment_detail']['account_type'] == 'secondary') {
                        $payment_details[$i]['Payment_detail']['account_type'] = 'primary';

                        $this->log("make secondary card primary (".$payment_details[$i]['Payment_detail']['id']."), delete primary", 'debug');

                        $this->Payment_detail->save($payment_details[$i]);

                        $this->Payment_detail->delete($id);
                        $this->Session->setFlash('Card Detail deleted Successfully.', 'success');
                        $this->redirect(array('action' => 'payments'));

                        break;
                    }
                }

            }
        }

        /*

        $this->Payment_detail->delete($id);
        $this->Session->setFlash('Card Detail deleted Successfully.', 'success');
        $this->redirect(array('action' => 'payments'));
        */
    }

// purchase lesson history of the student
    public function purchase_history() {
        $this->layout = 'student';
        $this->loadModel('Payment');
        $this->loadModel('Payment_detail');
        $user = $this->Auth->user();
        $user_id = $user['id'];
        $transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $user_id), 'order' => array('Payment.id' => 'DESC')));

        $payment_detail = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $user_id)));
        $this->set('payment_detail', $payment_detail);
        $time = 0;
        if (!empty($transactions)) {
            $min = 0;
            foreach ($transactions as $key => $transaction) {
                $getPack = $this->Price->findById($transaction['Payment']['pack']);
                if (!empty($getPack)) {
                    $transactions[$key]['Price']['pack'] = $getPack['Price']['pack'];
                }
                $total_time = $transaction['Payment']['total_time'];
                $transactions[$key]['Time'] = $this->secondsToTime($total_time);
            }


            $forPaid = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $user_id, 'Payment.status' => '1')));
            if (!empty($forPaid)) {
                $paid = 0;
                foreach ($forPaid as $k => $v) {
                    $paid += $v['Payment']['total_time'];
                }
                $converted_paid = $this->secondsToTime($paid);

                $this->set('converted_paid', $converted_paid);
            }

            $total_hour = $this->Total_hour->findByStudentId($user_id);
            $violin_hour = $this->Voilin_hour->findByStudentId($user_id);
            if (!empty($total_hour) || !empty($violin_hour)) {
                $total = @$total_hour['Total_hour']['total_time'] + @$violin_hour['Voilin_hour']['total_time'];

                $converted_time = $this->secondsToTime($total);
                $this->set('converted_time', $converted_time);
            }

            $this->set('transactions', $transactions);
            $this->set('time', $time);
        }

        //Lessons and Credits
        $other_transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $user_id, 'Payment.status <=' => '1', 'Payment.subject !=' => '11')));
        if (!empty($other_transactions)) {
            $exact_total = 0;
            foreach ($other_transactions as $all) {
                $exact_total += $all['Payment']['total_time'];
            }
            $other_purchased = $this->secondsToTime($exact_total);
            $this->set('other_purchased', $other_purchased);
        }

        $total_hours = $this->Total_hour->findByStudentId($user_id);

        if (!empty($total_hours)) {
            if (!empty($total_hours['Total_hour']['total_time']) && isset($total_hours['Total_hour']['total_time'])) {
                $converted_total = $this->secondsToTime($total_hours['Total_hour']['total_time']);

                $this->set('converted_total', $converted_total);
            }
            if (!empty($total_hours['Total_hour']['credits']) && isset($total_hours['Total_hour']['credits'])) {
                if ($total_hours['Total_hour']['credits'] > '0') {
                    $converted_credits = $this->secondsToTime($total_hours['Total_hour']['credits']);
                    $this->set('converted_credits', $converted_credits);
                } else {
                    if (abs($total_hours['Total_hour']['credits']) > '60') {
                        $converted_credits_negative = $this->secondsToTime($total_hours['Total_hour']['credits']);
                    } else {
                        $converted_credits_negative['second'] = $total_hours['Total_hour']['credits'];
                    }
                    $this->set('converted_credits_negative', $converted_credits_negative);
                }
            }
        }

        $violin_transactions = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $user_id, 'Payment.status <=' => '1', 'Payment.subject' => '11')));
        if (!empty($violin_transactions)) {
            $total_time = 0;
            foreach ($violin_transactions as $v_all) {
                $total_time += $v_all['Payment']['total_time'];
            }
            $violin_purchased = $this->secondsToTime($total_time);
            $this->set('violin_purchased', $violin_purchased);
        }

        $violin_hours = $this->Voilin_hour->findByStudentId($user_id);
        if (!empty($violin_hours)) {
            if (!empty($violin_hours['Voilin_hour']['total_time']) && isset($violin_hours['Voilin_hour']['total_time'])) {
                $converted_total1 = $this->secondsToTime($violin_hours['Voilin_hour']['total_time']);
                $this->set('converted_total1', $converted_total1);
            }
            if (!empty($violin_hours['Voilin_hour']['credits']) && isset($violin_hours['Voilin_hour']['credits'])) {
                if ($violin_hours['Voilin_hour']['credits'] > '0') {
                    $converted_credits1 = $this->secondsToTime($violin_hours['Voilin_hour']['credits']);
                    $this->set('converted_credits1', $converted_credits1);
                } else {
                    if (abs($violin_hours['Voilin_hour']['credits']) > '60') {
                        $converted_credits_negative1 = $this->secondsToTime($violin_hours['Voilin_hour']['credits']);
                    } else {
                        $converted_credits_negative1['second'] = $violin_hours['Voilin_hour']['credits'];
                    }
                    $this->set('converted_credits_negative1', $converted_credits_negative1);
                }
            }
        }
    }

// lessons completed by the student
    public function completed_lessons() {

        $this->layout = 'student';
        $user_id = $this->Auth->user('id');
        $this->set('user_id', $user_id);
        $completed_lesson = $this->Calendar->find('all', array('conditions' => array('Calendar.user_id' => $this->Auth->user('id'), 'OR' => array('Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')), 'deleted !=' => 'yes'), 'order' => array('Calendar.modified' => 'ASC')));
        $this->set('completed_lesson', $completed_lesson);
        $total = 0;
        if (!empty($completed_lesson)) {
            foreach ($completed_lesson as $completed) {
                $schedule_time = $completed['Calendar']['schedule_time'];
                $teacher = $this->User->findById($completed['Calendar']['teacher_id']);
                $total += $schedule_time;
            }

            if ($total <= 30) {
                $total_time = $total . '-Minutes';
            } else {
                $total_time = ($total / 60);

                if ($total_time <= 1) {
                    $total_time = $total_time . '-Hour';
                } else {
                    $total_time = $total_time . '-Hours';
                }
            }
            if (!empty($total_time)) {
                $this->set('total_time', $total_time);
            }


            $total_time_2_convert = 0;
            if (!empty($completed_lesson)) {
                foreach ($completed_lesson as $key => $completed_les) {
                    $time = $completed_les['Calendar']['schedule_time'];
                    $total_time_2_convert += $time;
                    if ($time >= '60') {
                        $set_time = $this->secondsToTime($time);
                        if (!empty($set_time['min']) && !empty($set_time['second'])) {
                            $completed_lesson[$key]['converted_time'] = $set_time['min'] . ' Hours ' . $set_time['second'] . ' Minutes';
                        } elseif (!empty($set_time['min']) && empty($set_time['second'])) {
                            $completed_lesson[$key]['converted_time'] = $set_time['min'] . ' Hours ';
                        } elseif (empty($set_time['min']) && !empty($set_time['second'])) {
                            $completed_lesson[$key]['converted_time'] = $set_time['second'] . ' Minutes';
                        } else {
                            $completed_lesson[$key]['converted_time'] = '-';
                        }
                    } else {
                        $completed_lesson[$key]['converted_time'] = $time . ' Minutes';
                    }
                }
                $this->set('completed_lesson', $completed_lesson);
            }

            $set_tim = $this->secondsToTime($total_time_2_convert);
            $this->set('set_time', $set_tim);

            if (!empty($teacher)) {
                $name = ucfirst($teacher['User']['first_name']) . ' ' . ucfirst($teacher['User']['last_name']);
                $this->set('teacher_name', $name);
            }
        }
        $total_minutes = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $this->Auth->user('id'))));
        $total_min = 0;
        $total_hour = '';
        foreach ($total_minutes as $minutes) {
            $min = $minutes['Payment']['total_time'];
            $total_min += $min;
            $total_left = $total_min - $total;
            $total_hour = $total_left / 60;
            if ($total_hour <= 1) {
                $total_hour = $total_hour . '-Hour';
            } elseif ($total_hour > 1) {
                $total_hour = $total_hour . '-Hours';
            }
        }

        if (!empty($total_hour)) {
            $this->set('total_hour', $total_hour);
        }
    }

// payment to be made by the student.
    public function make_payment() {
        $finished_processing = false;
        $this->layout = 'student';
        $email_data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Make Payment')));
        $subject = $this->Subject->find('all', array('conditions' => array('Subject.status' => '1'), 'order' => array('Subject.order' => 'asc')));
        $this->set('subject', $subject);
        $packages = $this->Pack->find('all', array('conditions' => array('Pack.status' => '1')));
        $this->set('packages', $packages);
        $user = $this->Auth->user();
        $user_id = $user['id'];
        $get_user = $this->User->findById($user_id);
//        pr($get_user); die;
        $this->set('get_user', $get_user);
        $admin = $this->Admin->find('first');
        $this->set('admin', $admin);
        $find_cards = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $user_id, 'Payment_detail.account_type' => 'primary'), 'limit' => '1'));
        if (empty($find_cards)) {
            $find_cards = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $user_id, 'Payment_detail.account_type !=' => 'primary')));
        }
        $this->set('find_cards', $find_cards);
        $packs = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $get_user['User']['pricing_type'])));
        $this->set('packs', $packs);
        $authorize_credentials = $this->Authorize->find('first');
        if ($this->request->is('post')) {
            if ($this->Payment->validates()) {
                if($this->Session->read('Student.payment_processing')!='true') {
                    $this->Session->write('Student.payment_processing', 'true');
                    $getCoupon = $this->Coupon->findById($this->request->data['Payment']['coupon_id']);
                    if (!empty($getCoupon)) {
                        $couponCount = $getCoupon['Coupon']['count'];
                        $couponCount += 1;
                    }
                    $subject_name = $this->Subject->findById($this->request->data['Payment']['subject']);
                    $pack_name1 = $this->Price->findById($this->request->data['Payment']['package_price']);
                    $total_time = $this->request->data['Payment']['duration'] * $this->request->data['Payment']['quantity'];
                    if ($total_time > 60) {
                        $convert = $this->secondsToTime($total_time);
                        if (!empty($convert['min']) && !empty($convert['second'])) {
                            $timing = $convert['min'] . ' Hours ' . $convert['second'] . ' Minutes';
                        } elseif (!empty($convert['min']) && empty($convert['second'])) {
                            $timing = $convert['min'] . ' Hours ';
                        } elseif (empty($convert['min']) && !empty($convert['second'])) {
                            $timing = $convert['second'] . ' Minutes';
                        }
                    } elseif ($total_time == 60) {
                        $convert = $this->secondsToTime($total_time);
                        $timing = $convert['min'] . ' Hour';
                    } else {
                        $timing = $total_time . ' Minutes';
                    }
                    $pack_name = $pack_name1['Price']['pack'];
                    $card = $this->Payment_detail->findById($this->request->data['Payment']['detail_id']);
                    $card_expiry = $card['Payment_detail']['year'] . '-' . $card['Payment_detail']['month'];
                    if ($this->request->data['Payment']['youpay'] > '0.00') {
                        require_once INCLUDE_PATH . 'payments/AuthorizeNet.php';
                        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
                            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['live_key'], $authorize_credentials['Authorize']['live_secret']);
                        } elseif (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'sandbox') {
                            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['sandbox_key'], $authorize_credentials['Authorize']['sandbox_secret']);
                        }
                        $transaction->amount = $this->request->data['Payment']['youpay'];
                        $transaction->card_num = base64_decode($card['Payment_detail']['card_number']);
                        $transaction->exp_date = $card_expiry;
                        $transaction->first_name = $card['Payment_detail']['first_name'];
                        $transaction->last_name = $card['Payment_detail']['last_name'];
                        $transaction->phone = $get_user['User']['primary_phone'];
                        $transaction->address = $card['Payment_detail']['address'];
                        $transaction->city = $card['Payment_detail']['city'];
                        $transaction->state = $card['Payment_detail']['state'];
                        $transaction->zip = $card['Payment_detail']['zip_code'];
                        $transaction->email = $get_user['User']['email'];
                        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
                            $transaction->setSandbox(false);
                        }
                        $response = $transaction->authorizeAndCapture();
                        //$this->log($response, 'debug');
                        if ($response->response_code == "1") {
                            $paymentData = array(
                                'user_id' => $user_id,
                                'coupon_code' => $this->request->data['Payment']['coupon_code'],
                                'transaction_id' => $response->transaction_id,
                                'invoice_number' => $response->invoice_number,
                                'amount' => $this->request->data['Payment']['youpay'],
                                'card_number' => $card['Payment_detail']['card_number'],
                                'exp_month' => $card['Payment_detail']['month'],
                                'exp_year' => $card['Payment_detail']['year'],
                                'cvv' => $card['Payment_detail']['cvv'],
                                'payment_on' => date("m/d/Y", time()),
                                'first_name' => $response->first_name,
                                'last_name' => $response->last_name,
                                'card_type' => $response->card_type,
                                'subject' => $this->request->data['Payment']['subject'],
                                'subject_id' => $this->request->data['Payment']['subject'],
                                'subject_name' => $subject_name['Subject']['subject'],
                                'duration' => $timing,
                                'pack' => $this->request->data['Payment']['package_price'],
                                'pack_name' => $pack_name,
                                'quantity' => $this->request->data['Payment']['quantity'],
                                'total_time' => $total_time,
                                'left_time' => $total_time,
                                'status' => '1',
                                'role' => 'paid',
                            );

                            //$this->logActivity($user_id, "", "", "make_payment", "successful charge", $this->request->data['Payment']['youpay'], "$", $this->request->data['Payment']['package_price'], "", false, true, "SUCCESS: " . $this->get_auth_response_details($response));
                            //$finished_processing = true;


                        } else {
                            $this->logActivity($user_id, "", "", "make_payment", "failed charge", $this->request->data['Payment']['youpay'], "$", $this->request->data['Payment']['package_price'], "", false, false, "FAIL: " . $this->get_auth_response_details($response));
                            $this->Session->setFlash(__('There was a problem processing your transaction. ' . $response->response_reason_text), 'error');
                            $this->Session->delete('Student.payment_processing');
                            //$this->redirect(array('controller' => 'student', 'action' => 'make_payment'));
                            $finished_processing = true;

                        }
                    } elseif ($this->request->data['Payment']['youpay'] == '0.00') {
                        $paymentData = array(
                            'user_id' => $user_id,
                            'coupon_code' => $this->request->data['Payment']['coupon_code'],
                            'transaction_id' => '',
                            'invoice_number' => '',
                            'amount' => $this->request->data['Payment']['youpay'],
                            'card_number' => $card['Payment_detail']['card_number'],
                            'exp_month' => $card['Payment_detail']['month'],
                            'exp_year' => $card['Payment_detail']['year'],
                            'cvv' => $card['Payment_detail']['cvv'],
                            'payment_on' => date("m/d/Y", time()),
                            'first_name' => $card['Payment_detail']['first_name'],
                            'last_name' => $card['Payment_detail']['last_name'],
                            'card_type' => $card['Payment_detail']['card_type'],
                            'subject' => $this->request->data['Payment']['subject'],
                            'subject_id' => $this->request->data['Payment']['subject'],
                            'subject_name' => $subject_name['Subject']['subject'],
                            'duration' => $timing,
                            'pack' => $this->request->data['Payment']['package_price'],
                            'pack_name' => $pack_name,
                            'quantity' => $this->request->data['Payment']['quantity'],
                            'total_time' => $total_time,
                            'left_time' => $total_time,
                            'status' => '1',
                            'role' => 'discounted',
                        );
                    }
                    if (!empty($paymentData) && isset($paymentData)) {
                        if ($this->Payment->save($paymentData)) {
                            if ($paymentData['subject'] == '11' && $user['User']['pricing_type'] <= 3) {
                                $if_v_exists = $this->Voilin_hour->findByStudentId($user_id);
                                if (!empty($if_v_exists) && isset($if_v_exists)) {
                                    $final = $if_v_exists['Voilin_hour']['total_time'] + $paymentData['total_time'];
                                    $this->Voilin_hour->id = $if_v_exists['Voilin_hour']['id'];
                                    $this->Voilin_hour->saveField('total_time', $final);
                                } else {
                                    $save['Voilin_hour']['student_id'] = $user_id;
                                    $save['Voilin_hour']['total_time'] = $paymentData['total_time'];
                                    $this->Voilin_hour->create();
                                    $this->Voilin_hour->save($save);
                                }
                                $this->logActivity($user_id, "", "", "make_payment", "payment successful - added violin hours", $paymentData['total_time'], "mins", $this->request->data['Payment']['package_price'], "", false, true, $paymentData['transaction_id']);
                            } else {
                                $if_exists = $this->Total_hour->findByStudentId($user_id);
                                if (!empty($if_exists) && isset($if_exists)) {
                                    $final = $if_exists['Total_hour']['total_time'] + $paymentData['total_time'];
                                    $this->Total_hour->id = $if_exists['Total_hour']['id'];
                                    $this->Total_hour->saveField('total_time', $final);
                                } else {
                                    $save['Total_hour']['student_id'] = $user_id;
                                    $save['Total_hour']['total_time'] = $paymentData['total_time'];
                                    $this->Total_hour->create();
                                    $this->Total_hour->save($save);
                                }
                                $this->logActivity($user_id, "", "", "make_payment", "payment successful - added total hours", $paymentData['total_time'], "mins", $this->request->data['Payment']['package_price'], "", false, true, $paymentData['transaction_id']);
                            }
                            if (!empty($getCoupon)) {
                                $this->Coupon->id = $getCoupon['Coupon']['id'];
                                if ($getCoupon['Coupon']['coupon_type'] == 'Single User') {
                                    $coupon['Coupon']['count'] = $couponCount;
                                    $coupon['Coupon']['status'] = '0';
                                } else {
                                    $coupon['Coupon']['count'] = $couponCount;
                                    $coupon['Coupon']['status'] = '1';
                                }
                                $this->Coupon->save($coupon);
                            }
                            $last_id = $this->Payment->getLastInsertId();
                            $pay = $this->Payment->findById($last_id);
                            $subject = $pay['Payment']['subject_name'];
                            $total_hour = $this->Total_hour->findByStudentId($user_id);
                            // pr($total_hour);
                            if (!empty($total_hour)) {
                                $left_in_acc = $total_hour['Total_hour']['total_time'];
                                // pr($left_in_acc); die;
                                if ($left_in_acc >= 60) {
                                    $converted_time = $this->secondsToTime($left_in_acc);
                                    if (!empty($converted_time)) {
                                        if (!empty($converted_time['min']) && !empty($converted_time['second'])) {
                                            $time = $converted_time['min'] . ' Hours ' . $converted_time['second'] . ' Minutes';
                                        } else if (!empty($converted_time['min']) && empty($converted_time['second'])) {
                                            $time = $converted_time['min'] . ' Hours ';
                                        } else if (empty($converted_time['min']) && !empty($converted_time['second'])) {
                                            $time = $converted_time['second'] . ' Minutes';
                                        } else {
                                            $time = ' - ';
                                        }
                                    } else {
                                        $time = $converted_time['second'] . ' Minutes';
                                    }
                                } else {
                                    $time = $left_in_acc . ' Minutes';
                                }
                            }
//                        pr($pay);
//                        pr($paymentData);
//                        pr($time);
// for admin
                            $Email = $this->getMailerForAddress($admin['Admin']['email'] );
                            $Email->template('payment_success');
                            $Email->emailFormat('html');
                            $Email->viewVars(array('paymentData' => $pay, 'admin' => $admin));
                            $Email->from(array('contactus@lessonsonthego.com' => 'Lessons On The Go'));
                            $Email->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                            $Email->subject('Student Payment.');
                            $data = $Email->send();
//                        pr($data);
//for client   

                            $Email1 = $this->getMailerForAddress($pay['User']['email']);
                            $Email1->template('successfully_paid');
                            $Email1->viewVars(array('paymentData' => $paymentData, 'user_details' => $pay, 'pack_name' => $pack_name, 'email_data' => $email_data, 'time' => $time));
                            $Email1->to(array($pay['User']['email'] => 'Lessons On The Go'));
                            $Email1->subject('Payment Succesful.');
                            $data1 = $Email1->send();
//                        pr($data1);
//                        die;
                            $this->Session->setFlash(__('Thanks! Your payment was successful.'), 'success');
                            $this->Session->delete('Student.payment_processing');
                            $this->redirect(array('controller' => 'student', 'action' => 'purchase_history'));
                        }
                    } elseif (!$finished_processing) {
                        $this->logActivity($user_id, "", "", "make_payment", "failed charge - no data", $this->request->data['Payment']['youpay'], "$", $this->request->data['Payment']['package_price'], "", false, false, "");
                        $this->Session->delete('Student.payment_processing');
                        $this->Session->setFlash(__('Lesson has not been purchased.  Please try again in a few minutes.'), 'error');
                        //$this->redirect(array('controller' => 'student', 'action' => 'make_payment'));
                    }
                } else {
                    $this->Session->setFlash(__('Payment is still processing.  Please try again in a few minutes.'), 'error');
                }
            } else {
                $errors = $this->Payment->validationErrors;
            }
        }
    }

    function cardMasking($decoded_number, $maskingCharacter = '*') {
        return str_repeat($maskingCharacter, strlen($decoded_number) - 4) . substr($decoded_number, -4);
        return false;
    }

    function cvvMasking($decoded_cvv, $maskingCharacter = '*') {
        return str_repeat($maskingCharacter, strlen($decoded_cvv));
        return false;
    }

// teachers of the particular studnt
    public function my_teachers() {
        $this->layout = 'student';
        $this->loadModel('Subject');
        $this->loadModel('Payment');
        $this->loadModel('Teacher_information');
        $this->Teacher_information->recursive = 2;
        $id = $this->Auth->user();
        $get_teacher = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.student_id' => $id['id'], 'Assigned_teacher.status' => '1')));
        if (!empty($get_teacher)) {
            foreach ($get_teacher as $teacher) {
                $teacher_id[] = $teacher['Assigned_teacher']['teacher_id'];
                $teacher_info = $this->User->find('all', array('conditions' => array('User.id' => $teacher_id), 'order' => array('User.last_name')));
            }
            $this->set('teacher_info', $teacher_info);
        }
    }

// when Apply button clicked for coupon
    public function ajax_payment() {
        $this->layout = 'ajax';
        $this->loadModel('Coupon');
        $this->loadModel('Price');
        $coupon = $_POST['coupon_code'];
        $quantity = $_POST['quantity'];
        $subject = $_POST['subject'];
        $duration = $_POST['duration'];
        $package_price = $_POST['package_price'];
        $getPricing = $this->Price->findById($package_price);
        if (!empty($getPricing) && isset($getPricing)) {
            $price = $getPricing['Price']['price'];
            $total_price = $quantity * $price;
        } else {
            $total_price = $quantity * 0;
        }

        $getCoupon = $this->Coupon->find('all', array('conditions' => array('Coupon.coupon_code' => $coupon, 'Coupon.status' => '1', 'Coupon.end_date >=' => date('m-d-Y'))));
        if (!empty($getCoupon)) {
            $today = date('m-d-Y');
            foreach ($getCoupon as $copon) {
                $end_date = date('m-d-Y', strtotime($copon['Coupon']['end_date']));
                if ($today <= $end_date) {
                    $coupon_id = $copon['Coupon']['id'];
                    $getDiscount_value = $copon['Coupon']['discount_value'];
                    $getDiscountType = $copon['Coupon']['discount_type'];
                    if ($getDiscountType == '%') {
                        $getDiscount = ($total_price * $getDiscount_value ) / 100;
                        $afterDisc = $total_price - ($total_price * $getDiscount_value ) / 100;
                    } elseif ($getDiscountType == '$') {
                        $getDiscount = $getDiscount_value;
                        $afterDisc = ($total_price - $getDiscount_value);
                    }

                    $response['coupon_id'] = $coupon_id;
                    $response['total'] = $total_price;
                    $response['discount'] = $getDiscount;
                    $response['discounted_amount'] = $afterDisc;
                } else {
                    $response['status'] = 'noMatch';
                }
            }
        } else {
            $getDiscount_value = 0;
            $getDiscount = $getDiscount_value;
            $afterDisc = ($total_price - $getDiscount_value);
            $response['status'] = 'notFound';
            $response['total'] = $total_price;
            $response['discount'] = $getDiscount;
            $response['discounted_amount'] = $afterDisc;
        }

        echo json_encode($response);
        die;
    }

// on selecting subject duration is calculated.
    public function ajax_get_duration() {
        $this->layout = 'ajax';
        $subject = $_POST['sub'];
        $this->loadModel('Price');
        $getDuration = $this->Price->find('all', array('conditions' => array('Price.subject' => $subject)));
        $this->set('getDuration', $getDuration);
    }

// On selecting duration for the subject, pack is shown in dropdown.
    public function ajax_get_pack() {
        $this->layout = 'ajax';
        $duration = $_POST['duration'];
        $subject = $_POST['subject'];
        $this->loadModel('Price');
        $getPack = $this->Price->find('all', array('conditions' => array('Price.duration' => $duration, 'Price.subject' => $subject)));
        $this->set('getPack', $getPack);
    }

// price is calculated on basis of selected subject, duration & pack.
    public function ajax_get_price() {
        $this->layout = 'ajax';
        $this->loadModel('Price');
        $pack = $_POST['pack'];
        $get_duration = $this->Price->findById($pack);
        $duration = $get_duration['Price']['duration'];
        $quantity = $_POST['quantity'];

        if (!empty($get_duration)) {
            $price = $get_duration['Price']['price'];
            $total_amount = $price * $quantity;
            $response['total'] = $total_amount;
            $response['discount'] = 0;
            $response['discounted_amount'] = $total_amount;
            $response['duration'] = $duration;
            $response['pack'] = $pack;
            echo json_encode($response);
            die;
        }
    }

    public function message_detail($teacher_id) {
        $this->layout = 'student';
        $this->loadModel('User');
        $this->loadModel('Message');
        $get_teacher = $this->User->find('first', array('conditions' => array('User.id' => $teacher_id)));
        $this->set('get_teacher', $get_teacher);
        $cur_user = $this->Auth->user('id');
        $this->set('cur_user', $cur_user);

        $message_to = $this->Message->find('all', array('conditions' => array('Message.send_to' => $teacher_id, 'Message.send_by' => $cur_user)));
        $message_by = $this->Message->find('all', array('conditions' => array('Message.send_by' => $teacher_id, 'Message.send_to' => $cur_user)));
        $messag_thread = array_merge((array) @ $message_to, (array) @$message_by);
        foreach ($messag_thread as $msg) {
            if ($msg['Message']['send_by'] != $cur_user) {
                $message['Message']['message_status'] = 'read';
                $this->Message->id = $msg['Message']['id'];
                $this->Message->save($message);
            }
        }

//     
        if (!empty($messag_thread)) {
            array_multisort($messag_thread, SORT_ASC, $messag_thread);
        }
        $this->set('messag_thread', $messag_thread);
        if ($this->request->is('post')) {

            $to_details = $this->User->findById($this->request->data['Message']['send_to']);
            $by_details = $this->User->findById($this->request->data['Message']['send_by']);

            $email_content = $this->Email_content->findByTitle('Message Notify');


            $this->request->data['Message']['message_status'] = 'unread';
            if ($this->request->data['Message']['file'] ['name'] != '') {
                $image = WWW_ROOT . 'document/' . time() . '_' . $this->request->data['Message']['file']['name'];
                move_uploaded_file($this->request->data['Message']['file']['tmp_name'], $image);
                $this->request->data['Message']['file'] = time() . '_' . $this->request->data['Message']['file']['name'];
            } else {
                $this->request->data['Message']['file'] = '';
            }
            $this->Message->create();

            if ($this->Message->save($this->request->data)) {

                $last_msg = $this->Message->getLastInsertId();
                $msg_content = $this->Message->findById($last_msg);

                $Email = $this->getMailerForAddress($to_details['User']['email']);
                $msg_url = BASE_URL . 'teacher/message_detail/' . $to_details['User']['id'];
                $this->Session->write('msgUrl', $msg_url);
                $Email->template('message');
                $Email->viewVars(array('to_details' => $to_details, 'by_details' => $by_details, 'email_content' => $email_content, 'msg_content' => $msg_content));
                $Email->to($to_details['User']['email']);
                $Email->subject($email_content['Email_content']['subject']);
                if (!empty($msg_content['Message']['file']) && isset($msg_content['Message']['file'])) {
                    $Email->attachments([
                        $msg_content['Message']['file'] => [
                            'file' => INCLUDE_PATH . 'document/' . $msg_content['Message']['file'],
                            'mimetype' => 'image/png',
                            'contentId' => 'my-unique-id'
                        ]
                    ]);
                }

                $Email->send();
                $url = BASE_URL . 'student/message_detail/' . $teacher_id;
                $this->redirect($url);
            }
        }
    }

    public function create_message() {
        $this->autoRender = FALSE;

        if (!empty($_POST['teacher'])) {
            if (!empty($_POST['comment']) && !empty($_FILES['file'])) {
                $save_messsage['Message']['send_to'] = $_POST['teacher'];
                $save_messsage['Message']['send_by'] = $this->Auth->user('id');
                $save_messsage['Message']['message'] = $_POST['comment'];
                if (!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])) {
                    $image = WWW_ROOT . 'document/' . time() . '_' . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $image);
                    $save_messsage['Message']['file'] = time() . '_' . $_FILES['file']['name'];
                }
                $save_messsage['Message']['message_status'] = 'unread';
            } elseif (!empty($_POST['comment']) && empty($_FILES['file'])) {
                $save_messsage['Message']['send_to'] = $_POST['teacher'];
                $save_messsage['Message']['send_by'] = $this->Auth->user('id');
                $save_messsage['Message']['message'] = $_POST['comment'];
                $save_messsage['Message']['message_status'] = 'unread';
            } elseif (!empty($_FILES['file']) && empty($_POST['comment'])) {
                $save_messsage['Message']['send_to'] = $_POST['teacher'];
                $save_messsage['Message']['send_by'] = $this->Auth->user('id');
                if (!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])) {
                    $image = WWW_ROOT . 'document/' . time() . '_' . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $image);
                    $save_messsage['Message']['file'] = time() . '_' . $_FILES['file']['name'];
                }
                $save_messsage['Message']['message_status'] = 'unread';
            }
            if ($this->Message->save($save_messsage)) {
                $email_content = $this->Email_content->findByTitle('Message Notify');
                $last_msg = $this->Message->getLastInsertId();
                $msg_content = $this->Message->findById($last_msg);
                $to_details = $this->User->findById($msg_content['Message']['send_to']);
                $by_details = $this->User->findById($msg_content['Message']['send_by']);
                $Email =  $this->getMailerForAddress($to_details['User']['email']);
                $Email->template('message');
                $Email->viewVars(array('to_details' => $to_details, 'by_details' => $by_details, 'email_content' => $email_content, 'msg_content' => $msg_content));
                $Email->to($to_details['User']['email']);
                $Email->subject($email_content['Email_content']['subject']);
                if (!empty($msg_content['Message']['file']) && isset($msg_content['Message']['file'])) {
                    $Email->attachments([
                        $msg_content['Message']['file'] => [
                            'file' => INCLUDE_PATH . 'document/' . $msg_content['Message']['file'],
                            'mimetype' => 'image/png',
                            'contentId' => 'my-unique-id'
                        ]
                    ]);
                }

                $Email->send();
                $res['status'] = 'success';
                echo json_encode($res);
                die;
            }
        } else {
            $res['status'] = 'failure';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_ajax_show_teacher() {
        $this->layout = 'ajax';
        $id = $_POST['id'];
        $users = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $id)));
        if (!empty($users)) {
            foreach ($users as $user) {
                $user_info = $this->User->find('all', array('conditions' => array('User.id' => $user['Payment']['teacher_assigned'])));
                if (!empty($user_info)) {
                    $this->set('user_info', $user_info);
                }
            }
        }
    }

    public function webadmin_add_credit() {
        $this->layout = 'ajax';
        $this->loadModel('User');
        $student_id = $_POST['id'];
        $hour = $_POST['hour'];
        $minutes = $_POST['minutes'];

        $this->loadModel('Payment');
        $payment['Payment']['user_id'] = $student_id;
        $payment['Payment']['amount'] = 0.0;
        $payment['Payment']['transaction_id'] = 0;
        $payment['Payment']['invoice_number'] = 0;
        $payment['Payment']['card_number'] = 0;
        $payment['Payment']['exp_month'] = 0;
        $payment['Payment']['exp_year'] = 0;
        $payment['Payment']['cvv'] = 0;
        $payment['Payment']['first_name'] = 'Admin';
        $payment['Payment']['last_name'] = ' ';
        $payment['Payment']['card_type'] = 'Credit';
        $payment['Payment']['card_image'] = ' ';
        $payment['Payment']['notes'] = ' ';
        $payment['Payment']['subject'] = 0;
        $payment['Payment']['subject_id'] = 0;
        $payment['Payment']['subject_name'] = 'Credit';
        $payment['Payment']['pack'] = 0;
        $payment['Payment']['pack_name'] = 'Admin adjustment';
        $payment['Payment']['quantity'] = 1;
        $payment['Payment']['role'] = 'paid';
        $payment['Payment']['status'] = 2;
        $payment['Payment']['payment_on'] = date("m/d/Y", time());

        $payment['Payment']['duration'] = "";
        $timeValue = 0;

        if(!empty($hour))  {
            $payment['Payment']['duration'] = $hour." hour";
            $timeValue = $hour * 60;
            if($hour > 0)  $payment['Payment']['duration'] .= "s";
            if(!empty($minutes)) $payment['Payment']['duration'] .= " ";
        }
        if(!empty($minutes))  {
            $payment['Payment']['duration'] .= $minutes." minutes";
            $timeValue += $minutes;
        }

        $payment['Payment']['total_time'] = $timeValue;
        $payment['Payment']['left_time'] = $timeValue;

        $this->Payment->save($payment);



        $if_exists = $this->Total_hour->findByStudentId($student_id);
        if (!empty($if_exists)) {
            $already_total = $if_exists['Total_hour']['total_time'];
            $already_credits = $if_exists['Total_hour']['credits'];
            if (!empty($hour) && !empty($minutes)) {

                $convert_time = $hour * 60;
                $final = $convert_time + $minutes + $already_total;
                $final_credits = $convert_time + $already_credits + $minutes;
                $this->Total_hour->id = $if_exists['Total_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $final_credits);
                $this->Total_hour->save($data);
//                $this->Total_hour->saveField('total_time', $final);
                $finddata = $this->Total_hour->findByStudentId($student_id);
                $convert = $finddata['Total_hour']['total_time'];
                $splited = $this->secondsToTime($convert);

                $res['status'] = 'both';
                $res['credit_hours'] = $splited['min'];
                $res['credit_minutes'] = $splited['second'];
            } elseif (!empty($hour) && empty($minutes)) {
                $convert_time = $hour * 60;
                $final = $convert_time + $already_total;
                $final_credits = $convert_time + $already_credits;
                $this->Total_hour->id = $if_exists['Total_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $final_credits);
                $this->Total_hour->save($data);
                $finddata = $this->Total_hour->findByStudentId($student_id);
                $convert = $finddata['Total_hour']['total_time'];
                $splited = $this->secondsToTime($convert);
                $res['status'] = 'hour';
                $res['credit_hours'] = $splited['min'];
                $res['credit_minutes'] = $splited['second'];
            } elseif (!empty($minutes) && empty($hour)) {

                $final = $minutes + $already_total;
                $final_credits = $minutes + $already_credits;
                $this->Total_hour->id = $if_exists['Total_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $final_credits);
                $this->Total_hour->save($data);
                $finddata = $this->Total_hour->findByStudentId($student_id);
                $convert = $finddata['Total_hour']['total_time'];
                $splited = $this->secondsToTime($convert);
                $res['status'] = 'minute';
                $res['credit_hours'] = $splited['min'];
                $res['credit_minutes'] = $splited['second'];
            }
        } else {
            $already_credits = 0;
            if (!empty($hour) && !empty($minutes)) {
                $convert_hour = $hour * 60;
                $final_time = $convert_hour + $minutes;
                $final_credits = $convert_hour + $minutes + $already_credits;
                $this->Total_hour->create();
                $save['Total_hour']['student_id'] = $student_id;
                $save['Total_hour']['credits'] = $final_credits;
                $save['Total_hour']['total_time'] = $final_time;
                $this->Total_hour->save($save);
                $get_data = $this->Total_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Total_hour']['total_time']);
                $res['status'] = 'both';
                $res['credit_hours'] = $converted_time['min'];
                $res['credit_minutes'] = $converted_time['second'];
            } elseif (!empty($hour) && empty($minutes)) {
                $convert = $hour * 60;
                $Final = $convert + $already_credits;
                $this->Total_hour->create();
                $save['Total_hour']['student_id'] = $student_id;
                $save['Total_hour']['credits'] = $Final;
                $save['Total_hour']['total_time'] = $convert;
                $this->Total_hour->save($save);
                $get_data = $this->Total_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Total_hour']['total_time']);
                $res['status'] = 'both';
                $res['credit_hours'] = $converted_time['min'];
                $res['credit_minutes'] = $converted_time['second'];
            } elseif (!empty($minutes) && empty($hour)) {
                $this->Total_hour->create();
                $save['Total_hour']['student_id'] = $student_id;
                $save['Total_hour']['credits'] = $minutes + $already_credits;
                $save['Total_hour']['total_time'] = $minutes;
                $this->Total_hour->save($save);
                $get_data = $this->Total_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Total_hour']['total_time']);
                $res['status'] = 'both';
                $res['credit_hours'] = $converted_time['min'];
                $res['credit_minutes'] = $converted_time['second'];
            }
        }

        $this->logActivity($student_id, "", "", "webadmin_add_credit", "", $timeValue, "mins", "" , "", true, true, "");

        echo json_encode($res);
        die;
    }

    public function webadmin_subtract_credit() {
        $this->layout = 'ajax';
        $this->loadModel('User');
        $this->User->recursive = -1;
        $student_id = $_POST['student_id'];
        $hour = $_POST['hour'];
        $minute = $_POST['minute'];


        $this->loadModel('Payment');
        $payment['Payment']['user_id'] = $student_id;
        $payment['Payment']['amount'] = 0.0;
        $payment['Payment']['transaction_id'] = 0;
        $payment['Payment']['invoice_number'] = 0;
        $payment['Payment']['card_number'] = 0;
        $payment['Payment']['exp_month'] = 0;
        $payment['Payment']['exp_year'] = 0;
        $payment['Payment']['cvv'] = 0;
        $payment['Payment']['first_name'] = 'Admin';
        $payment['Payment']['last_name'] = ' ';
        $payment['Payment']['card_type'] = 'Debit';
        $payment['Payment']['card_image'] = ' ';
        $payment['Payment']['notes'] = ' ';
        $payment['Payment']['subject'] = 0;
        $payment['Payment']['subject_id'] = 0;
        $payment['Payment']['subject_name'] = 'Debit';
        $payment['Payment']['pack'] = 0;
        $payment['Payment']['pack_name'] = 'Admin adjustment';
        $payment['Payment']['quantity'] = 1;
        $payment['Payment']['role'] = 'paid';
        $payment['Payment']['status'] = 2;
        $payment['Payment']['payment_on'] = date("m/d/Y", time());

        $payment['Payment']['duration'] = "- ";
        $timeValue = 0;

        if(!empty($hour))  {
            $payment['Payment']['duration'] .= $hour." hour";
            $timeValue = $hour * 60;
            if($hour > 0)  $payment['Payment']['duration'] .= "s";
            if(!empty($minute)) $payment['Payment']['duration'] .= " ";
        }
        if(!empty($minute))  {
            $payment['Payment']['duration'] .= $minute." minutes";
            $timeValue += $minute;
        }

        $payment['Payment']['total_time'] = $timeValue;
        $payment['Payment']['left_time'] = $timeValue;

        $this->Payment->save($payment);




        $find_data = $this->Total_hour->findByStudentId($student_id);

        if(empty($find_data)) {
            $this->Total_hour->create();
            $save['Total_hour']['student_id'] = $student_id;
            $save['Total_hour']['credits'] = 0;
            $save['Total_hour']['total_time'] = 0;
            $this->Total_hour->save($save);
            $find_data = $this->Total_hour->findByStudentId($student_id);
        }

        $already_time = $find_data['Total_hour']['total_time'];
        $already_crdit_time = $find_data['Total_hour']['credits'];


        if (!empty($hour) && !empty($minute)) {
            $converted_hr = $hour * 60;
            $final_sub = $already_time - ($converted_hr + $minute);
            $final_creddits = $already_crdit_time - ($converted_hr + $minute);
            $this->Total_hour->id = $find_data['Total_hour']['id'];
            $dta = array('total_time' => $final_sub, 'credits' => $final_creddits);
            $this->Total_hour->save($dta);
            $findData = $this->Total_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Total_hour']['total_time']);

            $res['status'] = 'convertedTime';
            $res['hours'] = $split['min'];
            $res['minutes'] = $split['second'];
        } elseif (!empty($hour) && empty($minute)) {
            $converted_hr = $hour * 60;
            $final_sub = $already_time - $converted_hr;
            $final_credits = $already_crdit_time - $converted_hr;
            $this->Total_hour->id = $find_data['Total_hour']['id'];
            $data = array('total_time' => $final_sub, 'credits' => $final_credits);
            $this->Total_hour->save($data);
            $findData = $this->Total_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Total_hour']['total_time']);
            $res['status'] = 'hour';
            $res['left_hours'] = $split['min'];
        } elseif (empty($hour) && !empty($minute)) {
            $final_sub = $already_time - $minute;
            $final_credits = $already_crdit_time - $minute;

            $this->Total_hour->id = $find_data['Total_hour']['id'];
            $final_data = array('total_time' => $final_sub, 'credits' => $final_credits);
            $this->Total_hour->save($final_data);
            $findData = $this->Total_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Total_hour']['total_time']);
            $res['status'] = 'ConvertedMinute';
            $res['minutes'] = $split['second'];
            $res['hours'] = $split['min'];
        } else {
            $res['status'] = 'no';
        }

        $this->logActivity($student_id, "", "", "webadmin_subtract_credit", "", $timeValue, "mins", "" , "", true, true, "");

        echo json_encode($res);
        die;
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
            'hour' => (int) $hours,
            'min' => (int) $minutes,
            'second' => (int) $seconds,
        );

        return $obj;
    }

    public function webadmin_resend_signup_details($id = NULL) {
        $this->autoRender = FALSE;
        $this->loadModel('User');
        $this->loadModel('Email_content');
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Student Resend Details')));
        $this->User->recursive = -1;
        $find_user = $this->User->findById($id);
        $pwd = $this->generateRandomString();
        $password = AuthComponent::password($pwd);
        $this->User->id = $id;
        $this->User->saveField('password', $password);
        $Email = $this->getMailerForAddress($find_user['User']['email']);
        $Email->template('resend_signup_details');
        $Email->viewVars(array('find_user' => $find_user, 'new_password' => $pwd, 'data' => $data));
        $Email->to($find_user['User']['email'], ucfirst($find_user['User']['first_name']) . ' ' . ucfirst($find_user['User']['last_name']));
        $Email->subject('New Sign up details');
        $Email->emailFormat('both');
        //$this->log('resend signup: '.$Email, 'debug');
        $Email->send();
        $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
        $this->Session->setFlash('Sign Up Details sent successfully.', 'admin_success');
    }

    public function webadmin_edit_card1($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Payment_detail');
        $find_data = $this->Payment_detail->findByStudentId($id);
        $this->set('find_data', $find_data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            if (!empty($find_data)) {
                $this->Payment_detail->id = $find_data['Payment_detail']['id'];
                if ($this->request->data['Payment_detail']['account_type'] == 1) {
                    $this->request->data['Payment_detail']['account_type'] = 'primary';
                } elseif ($this->request->data['Payment_detail']['account_type'] == 0) {
                    $this->request->data['Payment_detail']['account_type'] = 'secondary';
                }
                $get_account_pos = strrpos($this->request->data['Payment_detail']['card_number'], '*');
                $get_cvv_pos = strrpos($this->request->data['Payment_detail']['cvv'], '*');
                if (isset($get_account_pos) && $get_account_pos != '') {
                    $this->request->data['Payment_detail']['card_number'] = $find_data['Payment_detail']['card_number'];
                } else {
                    $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                }

                if (isset($get_cvv_pos) && $get_cvv_pos != '') {
                    $this->request->data['Payment_detail']['cvv'] = $find_data['Payment_detail']['cvv'];
                } else {
                    $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                }
                if ($this->Payment_detail->save($this->request->data)) {
                    $this->Session->setFlash('Card Details updated successfully.', 'admin_success');
                    $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            } else {
                $this->Payment_detail->create();
                if ($this->request->data['Payment_detail']['account_type'] == 1) {
                    $this->request->data['Payment_detail']['account_type'] = 'primary';
                } elseif ($this->request->data['Payment_detail']['account_type'] == 0) {
                    $this->request->data['Payment_detail']['account_type'] = 'secondary';
                }
                $this->request->data['Payment_detail']['student_id'] = $id;
                $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                if ($this->Payment_detail->save($this->request->data)) {
                    $this->Session->setFlash('Card Details added successfully.', 'admin_success');
                    $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        }
    }

    public function webadmin_add_card($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Payment_detail');
        $user_detail = $this->User->findById($id);
        $find_user = $this->Payment_detail->findByStudentId($id);

        if ($this->request->is('post')) {
            $same = $this->request->data['Payment_detail']['billing_address'];
            if ($same == 'same') {
                $this->request->data['Payment_detail']['address'] = $user_detail['User']['address'];
                $this->request->data['Payment_detail']['apartment'] = $user_detail['User']['suite'];
                $this->request->data['Payment_detail']['city'] = $user_detail['User']['city'];
                $this->request->data['Payment_detail']['state'] = $user_detail['User']['state'];
                $this->request->data['Payment_detail']['zip_code'] = $user_detail['User']['zip_code'];
            }
            if (empty($find_user)) {
                $this->request->data['Payment_detail']['account_type'] = 'primary';
            } elseif (!empty($find_user['Payment_detail']['account_type'])) {
                $this->request->data['Payment_detail']['account_type'] = 'secondary';
            }
            $this->request->data['Payment_detail']['student_id'] = $id;
            $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
            $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
//            pr($this->request->data);die;
            if ($this->Payment_detail->save($this->request->data)) {
                $this->Session->setFlash('Details saved successfully.', 'admin_success');
                $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
            }
        }
    }

    public function filter_lesson() {
        $this->layout = 'ajax';
        $this->loadModel('Teacher_information');
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));
        $conditions = array('conditions' => array(
                'and' => array(
                    'Calendar.start_date >=' => $start_date,
                    'Calendar.end_date <=' => $end_date
                ),
                'Calendar.completed_type' => 'markcompleted',
                'Calendar.user_id' => $_POST['studentId']
            ),
            'order' => array('Calendar.start_date')
        );
        $all_lessons = $this->Calendar->find('all', $conditions);
        $this->set('all_lessons', $all_lessons);
        $total = 0;
        foreach ($all_lessons as $teacher) {
            $teacher_id = $teacher['Calendar']['teacher_id'];
            $find_teacher = $this->Teacher_information->findByUserId($teacher_id);
            $teacher_name = ucfirst($find_teacher['Teacher_information']['first_name']) . ' ' . ucfirst($find_teacher['Teacher_information']['last_name']);
            $this->set('teacher_name', $teacher_name);

            $schedule_time = $teacher['Calendar']['schedule_time'];
            $total += $schedule_time;
        }
        if ($total >= 60) {
            $get_total = $this->secondsToTime($total);

            if (!empty($get_total['min']) && !empty($get_total['second'])) {
                $total_time = $get_total['min'] . '-Hour ' . $get_total['second'] . '-Minutes';
            } elseif (!empty($get_total['min']) && ($get_total['min'] <= 1)) {
                $total_time = $get_total['min'] . '-Hour';
            } elseif (!empty($get_total['min']) && ($get_total['min'] > 1)) {
                $total_time = $get_total['min'] . '-Hours';
            } elseif (!empty($get_total['second'])) {
                $total_time = $get_total['second'] . '-Minutes';
            }
        } else {
            $total_time = $total . '-Minutes';
        }

        if (!empty($total_time)) {
            $this->set('total_time', $total_time);
        }


        $total_minutes = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $this->Auth->user('id'), 'Payment.teacher_assigned !=' => ' ', 'Payment.status' => '0'), 'order' => 'Payment.created DESC'));
        $total_min = 0;
        $total_hour = '';
        foreach ($total_minutes as $minutes) {
            $min = $minutes['Payment']['total_time'];
            $total_min += $min;
            $total_left = $total_min - $total;
        }
        if (!empty($total_left)) {
            if ($total_left >= 60) {
                $total_hour1 = $this->secondsToTime($total_left);
                if (!empty($total_hour1['min']) && !empty($total_hour1['second'])) {
                    $total_hour = $total_hour1['min'] . '-Hour ' . $total_hour1['second'] . '-Minutes';
                } elseif (!empty($total_hour1['min']) && ($total_hour1['min'] <= 1)) {
                    $total_hour = $total_hour1['min'] . '-Hour';
                } elseif (!empty($total_hour1['min']) && ($total_hour1['min'] > 1)) {
                    $total_hour = $total_hour1['min'] . '-Hours';
                } elseif (!empty($total_hour1['second'])) {
                    $total_hour = $total_hour1['second'] . '-Minutes';
                }
            } else {
                $total_hour = $total_left . '-Minutes';
            }
        }
        if (!empty($total_hour)) {
            $this->set('total_hour', $total_hour);
        }
    }

    public function webadmin_purchases($id = Null) {
        $this->layout = 'admin';
        $find_all = $this->Payment->find('all', array('conditions' => array('Payment.user_id' => $id)));
        foreach ($find_all as $key => $value) {
            $findPack = $this->Price->findById($value['Payment']['pack']);

            if (!empty($findPack)) {
                $find_all[$key]['Pack']['pack'] = $findPack['Pack']['pack'];
            }
        }

        $this->set('find_all', $find_all);
    }

    public function webadmin_completed_lesson($id = NULL) {
        $this->layout = 'admin';
        $completed_lessons = $this->Calendar->find('all', array('conditions' => array('Calendar.user_id' => $id, 'OR' => array('Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')), 'deleted !=' => 'yes'), 'order' => array('Calendar.start_date')));
        // pr($completed_lessons);
        // die;
        $total = 0;
        if (!empty($completed_lessons)) {
            foreach ($completed_lessons as $key => $lessons) {
                $scheduled_time = $lessons['Calendar']['schedule_time'];
                if ($scheduled_time < 60) {
                    $completed_lessons[$key]['time'] = $scheduled_time . ' Minutes';
                } else {
                    $time = $this->secondsToTime($scheduled_time);
                    if (!empty($time['min']) && (!empty($time['second']))) {
                        if ($time['min'] == '1') {
                            $completed_lessons[$key]['time'] = $time['min'] . ' Hour ' . $time['second'] . ' Minutes';
                        } else {
                            $completed_lessons[$key]['time'] = $time['min'] . ' Hours ' . $time['second'] . ' Minutes';
                        }
                    } elseif (!empty($time['min']) && isset($time['min'])) {
                        if ($time['min'] == '1') {
                            $completed_lessons[$key]['time'] = $time['min'] . ' Hour';
                        } else {
                            $completed_lessons[$key]['time'] = $time['min'] . ' Hours';
                        }
                    } elseif (!empty($time['second']) && (isset($time['second']))) {
                        $completed_lessons[$key]['time'] = $time['second'] . ' Minutes';
                    } elseif (empty($time['min']) && empty($time['second'])) {
                        $completed_lessons[$key]['time'] = '-';
                    }
                }
                $teacher_id = $lessons['Calendar']['teacher_id'];
                $teacher = $this->User->findById($teacher_id);
                $completed_lessons[$key]['teacher'] = $teacher['User'];
                $total += $scheduled_time;
            }
            $this->set('completed_lessons', $completed_lessons);
            if ($total < 59) {
                $total_time = $total . '-Minutes';
            } else {
                $total_time = ($total / 60);

                if ($total_time <= 1) {
                    $total_time = $total_time . '-Hour';
                } else {
                    $total_time = $total_time . '-Hours';
                }
            }
            if (!empty($total_time)) {
                $this->set('total_time', $total_time);
            }



            $total_minutes = $this->Total_hour->find('first', array('conditions' => array('Total_hour.student_id' => $id)));
         //   pr($total_minutes);
//            $total_min = 0;
//            $total_hour = '';
//            foreach ($total_minutes as $minutes) {
//                $min = $minutes['Payment']['total_time'];
//                $total_min += $min;
//                $total_left = $total_min - $total;
//                $total_hour = $total_left / 60;
//                if ($total_hour <= 1) {
//                    $total_hour = $total_hour . '-Hour';
//                } elseif ($total_hour > 1) {
//                    $total_hour = $total_hour . '-Hours';
//                }
//            }

            if (!empty($total_minutes)) {
                $minutes = $total_minutes['Total_hour']['total_time'];
                if ($minutes > 60) {
                    $total_hour = $minutes / 60;
                    if ($total_hour <= 1) {
                        $total_hour = $total_hour . '-Hour';
                    } elseif ($total_hour > 1) {
                        $total_hour = $total_hour . '-Hours';
                    }
                } else {
                    $total_hour = $minutes.' Minutes';
                }

                $this->set('total_hour', $total_hour);
            }
        }
    }

    public function webadmin_edit_card($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Payment_detail');
        $find_data = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $id)));
        $this->set('find_data', $find_data);
        if (empty($find_data)) {
            if ($this->request->is('post')) {
                $this->Payment_detail->create();
                $this->request->data['Payment_detail']['account_type'] = 'primary';
                $this->request->data['Payment_detail']['student_id'] = $id;
                $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                if ($this->Payment_detail->save($this->request->data)) {
                    $this->Session->setFlash('Card Details added successfully.', 'admin_success');
                    $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } elseif (!empty($find_data)) {
            if ($this->request->is('put') || ($this->request->is('post'))) {
                $this->Payment_detail->id = $find_data['Payment_detail']['id'];
                $get_account_pos = strrpos($this->request->data['Payment_detail']['card_number'], '*');
                $get_cvv_pos = strrpos($this->request->data['Payment_detail']['cvv'], '*');
                if (isset($get_account_pos) && $get_account_pos != '') {
                    $this->request->data['Payment_detail']['card_number'] = $find_data['Payment_detail']['card_number'];
                } else {
                    $this->request->data['Payment_detail']['card_number'] = base64_encode($this->request->data['Payment_detail']['card_number']);
                }

                if (isset($get_cvv_pos) && $get_cvv_pos != '') {
                    $this->request->data['Payment_detail']['cvv'] = $find_data['Payment_detail']['cvv'];
                } else {
                    $this->request->data['Payment_detail']['cvv'] = base64_encode($this->request->data['Payment_detail']['cvv']);
                }
                if ($this->Payment_detail->save($this->request->data)) {
                    $this->Session->setFlash('Card Details updated successfully.', 'admin_success');
                    $this->redirect(array('controller' => 'student', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        }
    }

    public function webadmin_make_a_payment($id = NULL) {
        $this->layout = 'admin';
        $email_data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Make Payment')));
        $find_cards = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $id)));
        $this->set('find_cards', $find_cards);
        $get_user = $this->User->find('first', array('conditions' => array('id' => $id), 'recursive' => -1));
        $this->set('user', $get_user);
        $this->Subject->recursive = -1;
        $subjects = $this->Subject->find('all', array('order' => array('Subject.order' => 'asc')));
        $this->set('subjects', $subjects);
        $admin = $this->Admin->findById($this->Auth->user('id'));
//        $this->Price->recursive = -1;
//        $find_pack = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $get_user['User']['pricing_type'])));
//        $this->set('find_pack', $find_pack);
        $authorize_credentials = $this->Authorize->find('first');
        if ($this->request->is('post')) {
            $this->Payment->set($this->request->data);
            if ($this->Payment->validates()) {
                if($this->Session->read('Webadmin.Student.payment_processing.'.$id)!='true') {
                    $this->Session->write('Webadmin.Student.payment_processing.' . $id, 'true');
                    $this->Price->recursive = -1;
                    $get_duration = $this->Price->findById($this->request->data['Payment']['pack']);
                    $pack_name = $get_duration['Price']['pack'];
                    $cal = $get_duration['Price']['duration'] * 1;
                    $convert_duration = $this->secondsToTime($cal);
                    if (!empty($convert_duration['min']) && !empty($convert_duration['second'])) {
                        $cal1 = $convert_duration['min'] . ' Hours' . $convert_duration['second'] . ' Minutes';
                    } elseif (!empty($convert_duration['min']) && empty($convert_duration['second'])) {
                        $cal1 = $convert_duration['min'] . ' Hours';
                    } elseif (empty($convert_duration['min']) && !empty($convert_duration['second'])) {
                        $cal1 = $convert_duration['second'] . ' Minutes';
                    }
                    $this->Payment_detail->recursive = -1;
                    $payment_detail = $this->Payment_detail->findById($this->request->data['Payment']['detail_id']);
                    if ($this->request->data['Payment']['amount'] > '0') {
                        $this->Subject->recursive = -1;
                        $subject_name = $this->Subject->findById($this->request->data['Payment']['subject']);
                        $card_expiry = $payment_detail['Payment_detail']['year'] . '-' . $payment_detail['Payment_detail']['month'];
                        require_once INCLUDE_PATH . 'payments/AuthorizeNet.php';
                        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
                            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['live_key'], $authorize_credentials['Authorize']['live_secret']);
                        } elseif (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'sandbox') {
                            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['sandbox_key'], $authorize_credentials['Authorize']['sandbox_secret']);
                        }
                        //    $transaction = new AuthorizeNetAIM('99AJ26pH3rK', '89B3sbRUnFn87x6q');
                        $transaction->amount = $this->request->data['Payment']['amount'];
                        $transaction->card_num = base64_decode($payment_detail['Payment_detail']['card_number']);
                        $transaction->exp_date = $card_expiry;
                        $transaction->first_name = $payment_detail['Payment_detail']['first_name'];
                        $transaction->last_name = $payment_detail['Payment_detail']['last_name'];

                        $transaction->phone = $get_user['User']['primary_phone'];
                        $transaction->address = $payment_detail['Payment_detail']['address'];
                        $transaction->city = $payment_detail['Payment_detail']['city'];
                        $transaction->state = $payment_detail['Payment_detail']['state'];
                        $transaction->zip = $payment_detail['Payment_detail']['zip_code'];
                        $transaction->email = $get_user['User']['email'];
                        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
                            $transaction->setSandbox(false);
                        }
                        $response = $transaction->authorizeAndCapture();
                        if ($response->response_code == "1") {
                            $paymentData = array(
                                'user_id' => $id,
                                'transaction_id' => $response->transaction_id,
                                'invoice_number' => $response->invoice_number,
                                'amount' => $this->request->data['Payment']['amount'],
                                'card_number' => $payment_detail['Payment_detail']['card_number'],
                                'exp_month' => $payment_detail['Payment_detail']['month'],
                                'exp_year' => $payment_detail['Payment_detail']['year'],
                                'cvv' => $payment_detail['Payment_detail']['cvv'],
                                'payment_on' => date("m/d/Y", time()),
                                'first_name' => $response->first_name,
                                'last_name' => $response->last_name,
                                'card_type' => $response->card_type,
                                'subject' => $this->request->data['Payment']['subject'],
                                'subject_id' => $this->request->data['Payment']['subject'],
                                'subject_name' => $subject_name['Subject']['subject'],
                                'duration' => $cal1,
                                'pack' => $this->request->data['Payment']['pack'],
                                'pack_name' => $pack_name,
                                'total_time' => $cal,
                                'left_time' => $cal,
                                'notes' => $this->request->data['Payment']['notes'],
                                'quantity' => '1',
                                'status' => '1',
                                'role' => 'paid',
                            );
                            $this->Payment->create();
                            $purchased_date = $paymentData['payment_on'];

                            if ($this->Payment->save($paymentData)) {
                                if ($paymentData['subject_id'] == '11' && $get_user['User']['pricing_type'] <= 3) {
                                    $find_voilin = $this->Voilin_hour->findByStudentId($paymentData['user_id']);
                                    if (!empty($find_voilin)) {
                                        $total_voilin = $find_voilin['Voilin_hour']['total_time'] + $paymentData['total_time'];
                                        $this->Voilin_hour->id = $find_voilin['Voilin_hour']['id'];
                                        $this->Voilin_hour->saveField('total_time', $total_voilin);
                                    } else {
                                        $save_data['Voilin_hour']['student_id'] = $paymentData['user_id'];
                                        $save_data['Voilin_hour']['total_time'] = $paymentData['total_time'];
                                        $this->Voilin_hour->create();
                                        $this->Voilin_hour->save($save_data);
                                    }
                                    $this->logActivity($id, "", "", "webadmin_make_a_payment", "payment successful - added violin hours", $paymentData['total_time'], "mins", $this->request->data['Payment']['package_price'], $get_user['User']['pricing_type'], true, true, $paymentData['transaction_id']);

                                } else {
                                    $find_hour = $this->Total_hour->findByStudentId($paymentData['user_id']);

                                    if (!empty($find_hour)) {
                                        $update_time = $find_hour['Total_hour']['total_time'] + $paymentData['total_time'];
                                        $this->Total_hour->id = $find_hour['Total_hour']['id'];
                                        $this->Total_hour->saveField('total_time', $update_time);
                                    } else {
                                        $save_data['Total_hour']['student_id'] = $paymentData['user_id'];
                                        $save_data['Total_hour']['total_time'] = $paymentData['total_time'];
                                        $this->Total_hour->create();
                                        $this->Total_hour->save($save_data);
                                    }
                                    $this->logActivity($id, "", "", "webadmin_make_a_payment", "payment successful - added total hours", $paymentData['total_time'], "mins", $this->request->data['Payment']['package_price'], $get_user['User']['pricing_type'], true, true, $paymentData['transaction_id']);

                                }
                                $last_id = $this->Payment->getLastInsertID();
                                $find_payment = $this->Payment->findById($last_id);
                                $subject = $subject_name;
                                $total_hours = $this->Total_hour->findByStudentId($id);
                                if (!empty($total_hours)) {
                                    if ($total_hours >= '60') {
                                        $converted_duration = $this->secondsToTime($total_hours);
                                        if (!empty($converted_duration['min']) && !empty($converted_duration['second'])) {
                                            $time = $converted_duration['min'] . ' Hours ' . $converted_duration['second'] . ' Minutes';
                                        } elseif (!empty($total_hours['min']) && empty($total_hours['second'])) {
                                            $time = $total_hours['min'] . ' Hours ';
                                        } elseif (empty($total_hours['min']) && !empty($total_hours['second'])) {
                                            $time = $total_hours['second'] . ' Minutes ';
                                        } else {
                                            $time = ' - ';
                                        }
                                    } else {
                                        $time = $total_hours . ' Minutes';
                                    }
                                }

// for client
                                $Email = $this->getMailerForAddress($find_payment['User']['email']);
                                $Email->template('successfully_paid');
                                $Email->viewVars(array('paymentData' => $paymentData, 'user_details' => $find_payment, 'pack_name' => $pack_name, 'email_data' => $email_data, 'time' => $time));
                                $Email->to(array($find_payment['User']['email'] => 'Lessons On The Go'));
                                $Email->subject('Payment Succesful.');
                                $data = $Email->send();
// for admin
                                $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                                $Email1->template('amount_paid');
                                $Email1->emailFormat('html');
                                $Email1->viewVars(array('subject' => $subject, 'paymentData' => $find_payment, 'admin' => $admin, 'pack_name' => $pack_name));
                                $Email1->from(array('contactus@lessonsonthego.com' => 'Lessons On The Go'));
                                $Email1->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                                $Email1->subject('Payment Succesful.');
                                $Email1->send();
                                $this->Session->SetFlash(__('Payment successful.'), 'success');
                                $url = BASE_URL . 'webadmin/student/';
                                $this->Session->setFlash(__('Thanks! Your payment was successful'), 'success');
                                $this->redirect($url);
                            }
                        } else {
                            $this->logActivity($id, "", "", "webadmin_make_a_payment", "failed charge", "", "", "", "", true, false, $this->get_auth_response_details($response));
                            $this->Session->delete('Webadmin.Student.payment_processing.'.$id);
                            $this->Session->setFlash(__('Invalid Card Details. ' . $response->response_reason_text), 'error');
                        }
                    } elseif ($this->request->data['Payment']['amount'] == '0') {
                        $subject_name = $this->Subject->findById($this->request->data['Payment']['subject']);
                        $paymentData = array(
                            'user_id' => $id,
                            'transaction_id' => '0',
                            'invoice_number' => '0',
                            'amount' => $this->request->data['Payment']['amount'],
                            'card_number' => $payment_detail['Payment_detail']['card_number'],
                            'exp_month' => $payment_detail['Payment_detail']['month'],
                            'exp_year' => $payment_detail['Payment_detail']['year'],
                            'cvv' => $payment_detail['Payment_detail']['cvv'],
                            'payment_on' => date("m/d/Y", time()),
                            'first_name' => $payment_detail['Payment_detail']['first_name'],
                            'last_name' => $payment_detail['Payment_detail']['last_name'],
                            'card_type' => $payment_detail['Payment_detail']['card_type'],
                            'subject' => $this->request->data['Payment']['subject'],
                            'subject_id' => $this->request->data['Payment']['subject'],
                            'subject_name' => $subject_name['Subject']['subject'],
                            'duration' => $cal1,
                            'pack' => $this->request->data['Payment']['pack'],
                            'pack_name' => $pack_name,
                            'total_time' => $cal,
                            'left_time' => $cal,
                            'notes' => $this->request->data['Payment']['notes'],
                            'quantity' => '1',
                            'status' => '1',
                            'role' => 'paid',
                        );
                        $this->Payment->create();
                        $purchased_date = $paymentData['payment_on'];
                        if ($this->Payment->save($paymentData)) {
                            $find_hour = $this->Total_hour->findByStudentId($paymentData['user_id']);
                            if (!empty($find_hour)) {
                                $update_time = $find_hour['Total_hour']['total_time'] + $paymentData['total_time'];

                                $this->Total_hour->id = $find_hour['Total_hour']['id'];
                                $this->Total_hour->saveField('total_time', $update_time);
                            } else {

                                $save_data['Total_hour']['student_id'] = $paymentData['user_id'];
                                $save_data['Total_hour']['total_time'] = $paymentData['total_time'];
                                $this->Total_hour->create();
                                $this->Total_hour->save($save_data);
                            }
                            $last_id = $this->Payment->getLastInsertID();
                            $find_payment = $this->Payment->findById($last_id);
                            $subject = $subject_name;
                            $total_hours = $this->Total_hour->findByStudentId($id);
                            if (!empty($total_hours)) {
                                if ($total_hours >= '60') {
                                    $converted_duration = $this->secondsToTime($total_hours);
                                    if (!empty($converted_duration['min']) && !empty($converted_duration['second'])) {
                                        $time = $converted_duration['min'] . ' Hours ' . $converted_duration['second'] . ' Minutes';
                                    } elseif (!empty($total_hours['min']) && empty($total_hours['second'])) {
                                        $time = $total_hours['min'] . ' Hours ';
                                    } elseif (empty($total_hours['min']) && !empty($total_hours['second'])) {
                                        $time = $total_hours['second'] . ' Minutes ';
                                    } else {
                                        $time = ' - ';
                                    }
                                } else {
                                    $time = $total_hours . ' Minutes';
                                }
                            }
// for client
                            $Email = $this->getMailerForAddress($find_payment['User']['email']);
                            $Email->template('successfully_paid');
                            $Email->viewVars(array('paymentData' => $paymentData, 'user_details' => $find_payment, 'pack_name' => $pack_name, 'email_data' => $email_data, 'time' => $time));
                            $Email->to(array($find_payment['User']['email'] => 'Lessons On The Go'));
                            $Email->subject('Payment Succesful.');
                            $Email->send();

// for admin
                            $Email1 = $this->getMailerForAddress($admin['Admin']['email']);
                            $Email1->template('amount_paid');
                            $Email1->emailFormat('html');
                            $Email1->viewVars(array('subject' => $subject, 'paymentData' => $find_payment, 'admin' => $admin, 'pack_name' => $pack_name));
                            $Email1->from(array('contactus@lessonsonthego.com' => 'Lessons On The Go'));
                            $Email1->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                            $Email1->subject('Payment Succesful.');
                            $Email1->send();
                            $this->Session->delete('Webadmin.Student.payment_processing.'.$id);
                            $this->Session->SetFlash(__('Payment successful.'), 'success');
                            $url = BASE_URL . 'webadmin/student/';
                            $this->redirect($url);
                        }
                    }
                } else {
                    $this->Session->setFlash(__('Payment is still processing.  Please try again in a few minutes.'), 'error');
                }
            } else {
                $error = $this->Payment_detail->validationErrors;
            }
        }
    }

    public function webadmin_ajax_get_duration() {
        $this->layout = 'ajax';
        $this->Subject->recursive = -1;
        $subject_id = $_POST['sub_id'];
        $subject_name = $this->Subject->findById($subject_id);
        $this->set('subject_name', $subject_name);
        $get_duration = $this->Price->find('all', array('conditions' => array('Price.subject' => $subject_id)));
        if (!empty($get_duration)) {
            $this->set('get_duration', $get_duration);
        }
    }

    public function webadmin_ajax_get_pack() {
        $this->layout = 'ajax';
        $subject = $_POST['subject'];
        $duration = $_POST['duration'];
        $find_pack = $this->Price->find('all', array('conditions' => array('Price.subject' => $subject, 'Price.duration' => $duration)));
        if (!empty($find_pack)) {
            $this->set('find_pack', $find_pack);
        }
    }

    public function webadmin_assign_teacher() {
        $this->autoRender = FALSE;
        if (!empty($_POST['teacher_info_id'])) {
            $teacher_info = $this->Teacher_information->findById($_POST['teacher_info_id']);

            $savedata['Assigned_teacher']['student_id'] = $_POST['student_id'];
            $savedata['Assigned_teacher']['teacher_information_id'] = $teacher_info['Teacher_information']['id'];
            $savedata['Assigned_teacher']['teacher_id'] = $teacher_info['Teacher_information']['user_id'];
            $savedata['Assigned_teacher']['subject_id'] = $_POST['subject_id'];
            $savedata['Assigned_teacher']['special_amount'] = $_POST['special_rate'];
            $savedata['Assigned_teacher']['lesson_duration'] = $_POST['lesson_duration'];
            $savedata['Assigned_teacher']['status'] = '1';
            $this->Assigned_teacher->create();
            if ($this->Assigned_teacher->save($savedata)) {
                $res['status'] = 'success';
                echo json_encode($res);
                die;
            }
        } else {
            $res['status'] = 'failure';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_remove_teacher($student_id = NULL, $payment_id = NULL) {
        $this->autoRender = FALSE;
        $this->Payment->id = $payment_id;
        $this->Payment->saveField('teacher_assigned', '');
        $this->Session->setFlash('Teacher removed Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'student',
            'action' => 'purchases', $student_id, $payment_id, 'prefix' => 'webadmin'));
    }

    public function webadmin_get_teachers() {
        $this->layout = 'ajax';
        $find_teachers = $this->Teacher->find('all', array('conditions' => array('Teacher.subject_id' => $_POST['subject'])));
//        pr($find_teachers);die;
        if (!empty($find_teachers)) {
            foreach ($find_teachers as $key => $value) {
                $user_id = $value['Teacher_information']['user_id'];
                if (!empty($user_id)) {
                    $user = $this->User->findById($user_id);
                    $find_teachers[$key]['User'] = $user['User'];
                }
            }
            $this->set('find_teachers', $find_teachers);
        }
    }

    public function webadmin_add_credit_card() {
        $this->autoRender = FALSE;
        $student_id = $_POST['student_id'];
        if (!empty($_POST['name_on_card'])) {
            $already_student = $this->Payment_detail->find('first', array('conditions' => array('Payment_detail.student_id' => $_POST['student_id'], 'Payment_detail.account_type' => 'primary')));
            if (!empty($already_student)) {
                $card_detail['Payment_detail']['account_type'] = 'secondary';
            } else {
                $card_detail['Payment_detail']['account_type'] = 'primary';
            }

            $card_detail['Payment_detail']['student_id'] = $_POST['student_id'];
            $card_detail['Payment_detail']['name_on_card'] = $_POST['name_on_card'];
            $card_detail['Payment_detail']['card_number'] = base64_encode($_POST['card_number']);
            $card_detail['Payment_detail']['card_type'] = $_POST['card_type'];
            $card_detail['Payment_detail']['cvv'] = base64_encode($_POST['cvv']);
            $card_detail['Payment_detail']['month'] = $_POST['month'];
            $card_detail['Payment_detail']['year'] = $_POST['year'];
            $card_detail['Payment_detail']['first_name'] = $_POST['first_name'];
            $card_detail['Payment_detail']['last_name'] = $_POST['last_name'];

            if ($_POST['bill_add'] == 'different') {
                $card_detail['Payment_detail']['address'] = $_SESSION['different_address']['address'];
                $card_detail['Payment_detail']['apartment'] = $_SESSION['different_address']['apartment'];
                $card_detail['Payment_detail']['city'] = $_SESSION['different_address']['city'];
                $card_detail['Payment_detail']['state'] = $_SESSION['different_address']['state'];
                $card_detail['Payment_detail']['zip_code'] = $_SESSION['different_address']['zip_code'];
            } elseif ($_POST['bill_add'] == 'same') {
                $find_student = $this->User->findById($student_id);
                $card_detail['Payment_detail']['address'] = $find_student['User']['address'];
                $card_detail['Payment_detail']['apartment'] = $find_student['User']['suite'];
                $card_detail['Payment_detail']['city'] = $find_student['User']['city'];
                $card_detail['Payment_detail']['state'] = $find_student['User']['state'];
                $card_detail['Payment_detail']['zip_code'] = $find_student['User']['zip_code'];
            }
            $this->Payment_detail->create();
            if ($this->Payment_detail->save($card_detail)) {
                $res['status'] = 'success';
                $res['student_id'] = $student_id;
                $this->Session->delete('different_address');
            }
        } else {
            $res['status'] = 'failure';
        }
        echo json_encode($res);
        die;
    }

    public function webadmin_manage_teachers() {
        $this->layout = 'ajax';
        $subjects = $this->Subject->find('all');
        $this->set('subjects', $subjects);
        $student_id = $_POST['student_id'];
        $student = $this->User->findById($student_id);
        if (!empty($student)) {
            $this->set('student_detail', $student);
        }
        $find_teachers = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.student_id' => $student_id, 'Assigned_teacher.status' => '1')));

        if (!empty($find_teachers)) {
            foreach ($find_teachers as $key => $teachers) {
                $user = $this->User->findById($teachers['Assigned_teacher']['teacher_id']);
                if (!empty($user)) {
                    $find_teachers[$key]['Teacher'] = $this->User->findById($teachers['Assigned_teacher']['teacher_id']);
                }
            }
            $this->set('teachers', $find_teachers);
        }
    }

    public function webadmin_delete_assigned_teacher() {
        $id = $_POST['assigned_id'];
        $this->Assigned_teacher->id = $id;
        $this->Assigned_teacher->saveField('status', '0');
        $res['status'] = 'suc';
        echo json_encode($res);
        die;
    }

    public function webadmin_addDiffBillAddress() {
        $this->autoRender = FALSE;
        $save_data['student_id'] = $_POST['student_id'];
        $save_data['address'] = $_POST['address'];
        $save_data['apartment'] = $_POST['apt'];
        $save_data['city'] = $_POST['city'];
        $save_data['state'] = $_POST['state'];
        $save_data['zip_code'] = $_POST['zip'];
        if ($save_data) {
            $this->Session->write('different_address', $save_data);
            $res['status'] = 'suc';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_manage_cards() {
        $this->layout = 'ajax';
        $stu_id = $_POST['client_id'];
        $find_cards = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $stu_id)));
        $this->set('find_cards', $find_cards);
    }

    public function webadmin_delete_add_card() {
        $this->autoRender = FALSE;
        $get_detail = $this->Payment_detail->findById($_POST['card_id']);
        $student_id = $get_detail['Payment_detail']['student_id'];

        $all_student = $this->Payment_detail->find('all', array('conditions' => array('Payment_detail.student_id' => $student_id)));
        if ((count($all_student) - 1) == 1) {
            foreach ($all_student as $student) {
                if ($student['Payment_detail']['id'] != $_POST['card_id']) {
                    $this->Payment_detail->id = $student['Payment_detail']['id'];
                    $this->Payment_detail->saveField('account_type', 'primary');
                }
            }
        }

        $delete = $this->Payment_detail->delete($_POST['card_id']);
        if ($delete) {
            $res['status'] = 'del';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_get_card_details() {
        $this->layout = 'ajax';
        $card_details = $_POST['card_id'];
        $payment_detail = $this->Payment_detail->findById($card_details);
        if (!empty($payment_detail)) {
            $this->set('payment_detail', $payment_detail);
        }
    }

    public function webadmin_edit_card_details() {
        $this->autoRender = FALSE;
        $payment_id = $_POST['payment_id'];
        $find_data = $this->Payment_detail->findById($payment_id);
        $save_data['Payment_detail']['name_on_card'] = $_POST['name_on_card'];

        $get_account_pos = strrpos($_POST['card_number'], '*');
        if ($get_account_pos) {
            $save_data['Payment_detail']['card_number'] = $find_data['Payment_detail']['card_number'];
        } else {
            $save_data['Payment_detail']['card_number'] = base64_encode($_POST['card_number']);
        }



        $save_data['Payment_detail']['card_type'] = $_POST['card_type'];
        $get_cvv_pos = strrpos($_POST['cvv'], '*');
        if ($get_cvv_pos) {
            $save_data['Payment_detail']['cvv'] = $find_data['Payment_detail']['cvv'];
        } else {
            $save_data['Payment_detail']['cvv'] = base64_encode($_POST['cvv']);
        }



        $save_data['Payment_detail']['month'] = $_POST['month'];
        $save_data['Payment_detail']['year'] = $_POST['year'];
        $save_data['Payment_detail']['first_name'] = $_POST['first_name'];
        $save_data['Payment_detail']['last_name'] = $_POST['last_name'];
        $save_data['Payment_detail']['address'] = $_POST['address'];
        $save_data['Payment_detail']['apartment'] = $_POST['apt'];
        $save_data['Payment_detail']['city'] = $_POST['city'];
        $save_data['Payment_detail']['state'] = $_POST['state'];
        $save_data['Payment_detail']['zip_code'] = $_POST['zip_code'];
        $this->Payment_detail->id = $payment_id;

        $verify_card_data = $save_data;
        $verify_card_data['Payment_detail']['card_number']  = base64_decode($save_data['Payment_detail']['card_number']);
        $verify_card_data['Payment_detail']['cvv'] = base64_decode($save_data['Payment_detail']['cvv']);

        $user = $this->User->findById($find_data['Payment_detail']['student_id']);
        //$verifyCard = $this->verifyCardDetails($verify_card_data,$user,1);
        $verifyCard=1;

        if($verifyCard === 1) {
            if ($this->Payment_detail->save($save_data)) {
                $res['status'] = 'success';
                echo json_encode($res);
                die;
            }
        } else {
            $res['status'] = 'failure';
            $res['message'] = $verifyCard;
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_get_pack_price() {
        $this->autoRender = FALSE;
        $get_price = $this->Price->findById($_POST['price_id']);
        if (!empty($get_price)) {
            $res['status'] = 'success';
            $res['price'] = $get_price['Price']['price'];
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_add_voilin() {
        $this->autoRender = FALSE;
        $student_id = $_POST['student_id'];
        $hour = $_POST['voilin_hour'];
        $minutes = $_POST['voilin_minutes'];
        $if_exists = $this->Voilin_hour->findByStudentId($student_id);

        $this->loadModel('Payment');
        $payment['Payment']['user_id'] = $student_id;
        $payment['Payment']['amount'] = 0.0;
        $payment['Payment']['transaction_id'] = 0;
        $payment['Payment']['invoice_number'] = 0;
        $payment['Payment']['card_number'] = 0;
        $payment['Payment']['exp_month'] = 0;
        $payment['Payment']['exp_year'] = 0;
        $payment['Payment']['cvv'] = 0;
        $payment['Payment']['first_name'] = 'Admin';
        $payment['Payment']['last_name'] = ' ';
        $payment['Payment']['card_type'] = 'Credit';
        $payment['Payment']['card_image'] = ' ';
        $payment['Payment']['notes'] = ' ';
        $payment['Payment']['subject'] = 0;
        $payment['Payment']['subject_id'] = 0;
        $payment['Payment']['subject_name'] = 'Credit';
        $payment['Payment']['pack'] = 0;
        $payment['Payment']['pack_name'] = 'Admin adjustment';
        $payment['Payment']['quantity'] = 1;
        $payment['Payment']['role'] = 'paid';
        $payment['Payment']['status'] = 2;
        $payment['Payment']['payment_on'] = date("m/d/Y", time());

        $payment['Payment']['duration'] = "";
        $timeValue = 0;


        if (!empty($if_exists)) {
            $already_total = $if_exists['Voilin_hour']['total_time'];
            $already_credits = $if_exists['Voilin_hour']['credits'];
            if (!empty($hour) && !empty($minutes)) {
                $convert_time = $hour * 60;
                $final = $convert_time + $minutes + $already_total;
                $finl_credits = $convert_time + $minutes + $already_credits;
                $this->Voilin_hour->id = $if_exists['Voilin_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $finl_credits);
                $this->Voilin_hour->save($data);
                $finddata = $this->Voilin_hour->findByStudentId($student_id);
                $convert = $finddata['Voilin_hour']['total_time'];
                $splited = $this->secondsToTime($convert);

                $res['status'] = 'both';
                $res['voilin_hours'] = $splited['min'];
                $res['voilin_minutes'] = $splited['second'];
            } elseif (!empty($hour) && empty($minutes)) {
                $convert_time = $hour * 60;
                $final = $convert_time + $already_total;
                $final_credits = $convert_time + $already_credits;
                $this->Voilin_hour->id = $if_exists['Voilin_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $final_credits);
                $this->Voilin_hour->save($data);
                $finddata = $this->Voilin_hour->findByStudentId($student_id);
                $convert = $finddata['Voilin_hour']['total_time'];
                $splited = $this->secondsToTime($convert);
                $res['status'] = 'hour';
                $res['voilin_hours'] = $splited['min'];
                $res['voilin_minutes'] = $splited['second'];
            } elseif (!empty($minutes) && empty($hour)) {
                $final = $minutes + $already_total;
                $final_credits = $minutes + $already_credits;
                $this->Voilin_hour->id = $if_exists['Voilin_hour']['id'];
                $data = array('total_time' => $final, 'credits' => $final_credits);
                $this->Voilin_hour->save($data);
                $finddata = $this->Voilin_hour->findByStudentId($student_id);
                $convert = $finddata['Voilin_hour']['total_time'];
                $splited = $this->secondsToTime($convert);
                $res['status'] = 'minute';
                $res['voilin_hours'] = $splited['min'];
                $res['voilin_minutes'] = $splited['second'];
            }
        } else {
            if (!empty($hour) && !empty($minutes)) {
                $convert_hour = $hour * 60;
                $final_time = $convert_hour + $minutes;
                $this->Voilin_hour->create();
                $save['Voilin_hour']['student_id'] = $student_id;
                $save['Voilin_hour']['total_time'] = $final_time;
                $this->Voilin_hour->save($save);
                $get_data = $this->Voilin_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Voilin_hour']['total_time']);
                $res['status'] = 'both';
                $res['voilin_hours'] = $converted_time['min'];
                $res['voilin_minutes'] = $converted_time['second'];
            } elseif (!empty($hour) && empty($minutes)) {
                $convert = $hour * 60;
                $this->Voilin_hour->create();
                $save['Voilin_hour']['student_id'] = $student_id;
                $save['Voilin_hour']['total_time'] = $convert;
                $this->Voilin_hour->save($save);
                $get_data = $this->Voilin_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Voilin_hour']['total_time']);
                $res['status'] = 'both';
                $res['voilin_hours'] = $converted_time['min'];
                $res['voilin_minutes'] = $converted_time['second'];
            } elseif (!empty($minutes) && empty($hour)) {
                $this->Voilin_hour->create();
                $save['Voilin_hour']['student_id'] = $student_id;
                $save['Voilin_hour']['total_time'] = $minutes;
                $this->Voilin_hour->save($save);
                $get_data = $this->Voilin_hour->findByStudentId($student_id);
                $converted_time = $this->secondsToTime($get_data['Voilin_hour']['total_time']);
                $res['status'] = 'both';
                $res['voilin_hours'] = $converted_time['min'];
                $res['voilin_minutes'] = $converted_time['second'];
            }
        }

        $this->logActivity($student_id, "", "", "webadmin_add_violin_credit", "", $timeValue, "mins", "" , "", true, true, "");

        echo json_encode($res);
        die;
    }

    public function webadmin_subtract_voilin_credit() {
//        pr($_POST);die;
        $this->autoRender = FALSE;
        $student_id = $_POST['student_id'];
        $hour = $_POST['voilinHour'];
        $minute = $_POST['voilinMinutes'];
        $find_data = $this->Voilin_hour->findByStudentId($student_id);

        if(empty($find_data)) {
            $this->Voilin_hour->create();
            $save['Voilin_hour']['student_id'] = $student_id;
            $save['Voilin_hour']['total_time'] = 0;
            $this->Voilin_hour->save($save);
            $find_data = $this->Voilin_hour->findByStudentId($student_id);
        }

        $this->loadModel('Payment');
        $payment['Payment']['user_id'] = $student_id;
        $payment['Payment']['amount'] = 0.0;
        $payment['Payment']['transaction_id'] = 0;
        $payment['Payment']['invoice_number'] = 0;
        $payment['Payment']['card_number'] = 0;
        $payment['Payment']['exp_month'] = 0;
        $payment['Payment']['exp_year'] = 0;
        $payment['Payment']['cvv'] = 0;
        $payment['Payment']['first_name'] = 'Admin';
        $payment['Payment']['last_name'] = ' ';
        $payment['Payment']['card_type'] = 'Debit';
        $payment['Payment']['card_image'] = ' ';
        $payment['Payment']['notes'] = ' ';
        $payment['Payment']['subject'] = 0;
        $payment['Payment']['subject_id'] = 0;
        $payment['Payment']['subject_name'] = 'Debit';
        $payment['Payment']['pack'] = 0;
        $payment['Payment']['pack_name'] = 'Admin adjustment';
        $payment['Payment']['quantity'] = 1;
        $payment['Payment']['role'] = 'paid';
        $payment['Payment']['status'] = 2;
        $payment['Payment']['payment_on'] = date("m/d/Y", time());

        $payment['Payment']['duration'] = "- ";
        $timeValue = 0;

        $already_time = $find_data['Voilin_hour']['total_time'];
        $already_credits_time = $find_data['Voilin_hour']['credits'];

        if (!empty($hour) && !empty($minute)) {
            $converted_hr = $hour * 60;
            $final_sub = $already_time - ($converted_hr + $minute);
            $final_credits = $already_credits_time - ($converted_hr + $minute);
            $this->Voilin_hour->id = $find_data['Voilin_hour']['id'];
            $data = array('total_time' => $final_sub, 'credits' => $final_credits);
            $this->Voilin_hour->save($data);
            $findData = $this->Voilin_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Voilin_hour']['total_time']);

            $res['status'] = 'convertedTime';
            $res['hours'] = $split['min'];
            $res['minutes'] = $split['second'];
        } elseif (!empty($hour) && empty($minute)) {
            $converted_hr = $hour * 60;
            $final_sub = $already_time - $converted_hr;
            $final_credit = $already_credits_time - $converted_hr;
            $this->Voilin_hour->id = $find_data['Voilin_hour']['id'];
            $data = array('total_time' => $final_sub, 'credits' => $final_credit);
            $this->Voilin_hour->save($data);
            $findData = $this->Voilin_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Voilin_hour']['total_time']);
            $res['status'] = 'hour';
            $res['left_hours'] = $split['min'];
        } elseif (empty($hour) && !empty($minute)) {
            $final_sub = $already_time - $minute;
            $final_credts = $already_credits_time - $minute;
            $this->Voilin_hour->id = $find_data['Voilin_hour']['id'];
            $data = array('total_time' => $final_sub, 'credits' => $final_credts);
            $this->Voilin_hour->save($data);
            $findData = $this->Voilin_hour->findByStudentId($student_id);
            $split = $this->secondsToTime($findData['Voilin_hour']['total_time']);
            $res['status'] = 'ConvertedMinute';
            $res['minutes'] = $split['second'];
            $res['hours'] = $split['min'];
        } else {
            $res['status'] = 'no';
        }

        $this->logActivity($student_id, "", "", "webadmin_subtract_violin_credit", "", $timeValue, "mins", "" , "", true, true, "");

        echo json_encode($res);
        die;
    }

    public function webadmin_finding_subject() {
        $this->layout = 'ajax';
        $student_id = $_POST['student_id'];
        $user = $this->User->findById($student_id);
        $this->set('user', $user);
        $all_subjects = $this->Subject->find('all', array('order' => array('Subject.order' => 'ASC')));
        $this->set('all_subjects', $all_subjects);
    }

    public function webadmin_update_assigned_teacher() {
        $this->autoRender = FALSE;
        $id = $_POST['id'];
        $data['Assigned_teacher']['special_amount'] = $_POST['specl_amt'];
        $data['Assigned_teacher']['subject_id'] = $_POST['special_sub'];
        $data['Assigned_teacher']['lesson_duration'] = $_POST['lesson_dur'];

        if (!empty($id)) {
            $this->Assigned_teacher->id = $id;
            $this->Assigned_teacher->save($data);
            $res['status'] = 'suc';
            echo json_encode($res);
            die;
        }
    }

    public function get_subject_pack() {
        $this->layout = 'ajax';
//        pr($_POST);die;
        $student_id = $_POST['student_id'];
        $subject = $_POST['subject'];
        $getUser = $this->User->findById($student_id);
        if ($subject == '11' && $getUser['User']['voilin_price'] == 'Yes') {
            $find = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => '1'), 'order' => array('Price.order' => 'ASC')));
        } else {  //formerly if ($subject != '11')
            $find = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $getUser['User']['pricing_type']), 'order' => array('Price.order' => 'ASC')));
        }
        $this->set('find', $find);
    }

    public function webadmin_show_pack() {
        $this->layout = 'ajax';
        $student_id = $_POST['student_id'];
        $subject = $_POST['subject'];
        $getUser = $this->User->findById($student_id);
        if ($subject == '11' && $getUser['User']['voilin_price'] == 'Yes') {
                $find = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => '1'), 'order' => array('Price.order' => 'ASC')));
        } else { //formerly if ($subject != '11')
            $find = $this->Price->find('all', array('conditions' => array('Price.pricing_type' => $getUser['User']['pricing_type']), 'order' => array('Price.order' => 'ASC')));
        }
        $this->set('find', $find);
    }

    public function webadmin_edit_additional($parent_id) {
        $this->layout = 'admin';
        $subjects = $this->Subject->find('all');
        $this->set('subjects', $subjects);
        $additional_user = $this->Child_user->findById($parent_id);
        $this->set('additional_user', $additional_user);
        if ($this->request->is('put') || $this->request->is('post')) {
            $this->Child_user->id = $parent_id;
            if ($this->Child_user->save($this->request->data)) {

                $this->Session->setFlash(__('Additional Students updated successfully.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function additional_student() {
        $this->layout = 'student';
        $subjects = $this->Subject->find('all');
        $this->set('subjects', $subjects);
        $students = $this->Child_user->find('all', array('conditions' => array('Child_user.user_id' => $this->Auth->user('id'))));
        $this->set('students', $students);
    }

    public function delete_additional($id) {
        $this->autoRender = FALSE;
        $this->Child_user->delete($id);
        $this->Session->setFlash(__('Additional student removed from account.'), 'success');
        $this->redirect(array('action' => 'additional_student'));
    }

    public function add_additional_student() {
        $this->autoRender = FALSE;
        $id = $this->Auth->user('id');
        if (!empty($id)) {
            $add['Child_user']['user_id'] = $this->Auth->user('id');
            $add['Child_user']['firstname'] = $_POST['firstname'];
            $add['Child_user']['lastname'] = $_POST['lastname'];
            $add['Child_user']['age'] = $_POST['age'];
            $add['Child_user']['subject'] = $_POST['subject'];
            $this->Child_user->create();
            $this->Child_user->save($add);
            $res['status'] = 'success';
        } else {
            $res['status'] = 'failure';
        }
        echo json_encode($res);
        die;
    }

    public function get_additional() {
        $this->layout = 'ajax';
        $id = $_POST['id'];
        $subjects = $this->Subject->find('all');
        $this->set('subjects', $subjects);
        $get_Data = $this->Child_user->findById($id);
        $this->set('get_Data', $get_Data);
    }

    public function edit_add() {
        $this->autoRender = FALSE;
        $id = $_POST['stu_id'];
        if (!empty($id)) {
            $this->Child_user->id = $id;
            $edit['Child_user']['firstname'] = $_POST['fname'];
            $edit['Child_user']['lastname'] = $_POST['lname'];
            $edit['Child_user']['age'] = $_POST['age'];
            $edit['Child_user']['subject'] = $_POST['subject'];
            $this->Child_user->save($edit);
            $res['status'] = 'true';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_additional_students($id) {
        $this->layout = 'admin';
        $get_all = $this->Child_user->find('all', array('conditions' => array('Child_user.user_id' => $id)));
        $this->set('get_all', $get_all);
    }

    public function webadmin_delete_additional($id, $user_id) {
        $this->autoRender = FALSE;
        $this->Child_user->delete($id);
        $this->Session->setFlash(__('Delete successfully.'), 'success');
        $url = BASE_URL . 'webadmin/student/additional_students/' . $user_id;
        $this->redirect(array('action' => 'index'));
    }

    public function webadmin_email_duration1() {
        $this->autoRender = FALSE;
        $if_exists = $this->Email_duration->findByUserId($_POST['stu_id']);

        if (empty($if_exists)) {
            $data['Email_duration']['user_id'] = $_POST['stu_id'];
            $data['Email_duration']['last'] = $_POST['last'];
            $data['Email_duration']['second'] = $_POST['second'];
            $this->Email_duration->create();
            if ($this->Email_duration->save($data)) {
                $res['status'] = 'success';
                echo json_encode($res);
                die;
            }
        } else {
            $data['Email_duration']['last'] = $_POST['last'];
            $data['Email_duration']['second'] = $_POST['second'];
            $this->Email_duration->id = $if_exists['Email_duration']['id'];
            if ($this->Email_duration->save($data)) {
                $res['status'] = 'updated';
                echo json_encode($res);
                die;
            }
        }
    }

    public function webadmin_show_email_time() {
        $this->layout = 'ajax';
        $student_id = $_POST['student_id'];
        $if_exists = $this->Email_duration->findByUserId($student_id);
        $this->set('if_exists', $if_exists);
    }

    public function webadmin_email_duration() {
        $this->layout = 'admin';
        $find = $this->Email_duration->find('first');
        $this->set('find', $find);

        if ($this->request->is('put') || $this->request->is('post')) {
            $this->Email_duration->id = $find['Email_duration']['id'];
            if ($this->Email_duration->save($this->request->data)) {
                $this->Session->setFlash(__('Email duration updated successfully.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function ajax_remove_additional() {
        $this->autoRender = FALSE;
        if (!empty($_POST['child_id'])) {
            $this->Child_user->delete($_POST['child_id']);
            $res['status'] = 'success';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_ajax_delete_additional() {
        $this->autoRender = FALSE;
        if (!empty($_POST['child_id'])) {
            $this->Child_user->delete($_POST['child_id']);
            $res['status'] = 'success';
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_ajax_search() {
        $this->layout = 'ajax';
        $this->User->recursive = -1;

        $conditions = array(
            'OR' => array(
                'User.first_name LIKE' => '%' . $_POST['search'] . '%',
                'User.last_name LIKE' => '%' . $_POST['search'] . '%',
                'User.student_firstname LIKE' => '%' . $_POST['search'] . '%',
                'User.student_lastname LIKE' => '%' . $_POST['search'] . '%',
                'User.subject LIKE' => '%' . $_POST['search'] . '%',
                'User.email LIKE' => '%' . $_POST['search'] . '%',
                'User.created LIKE' => '%' . date('Y-m-d', strtotime($_POST['search'])) . '%'
            ),
            'User.role' => '1'
        );
        $data = $this->User->find('all', array('conditions' => $conditions));


        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $student_id = $value['User']['id'];
                $total_hr = $this->Total_hour->findByStudentId($student_id);
                if (!empty($total_hr['Total_hour']) && isset($total_hr['Total_hour'])) {
                    $data[$key]['Total_hour'] = $total_hr['Total_hour'];
                }
            }

            $this->set('data', $data);
        }
    }

    public function webadmin_student_activity($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Activity');
        $find_data = $this->Activity->findByStudentId($id);


    }

    public function get_auth_response_details($response) {
        $retVal = "Response: code: ".$response->response_code.", subcode: ".$response->response_subcode.", reason_code: ".
            $response->response_reason_code.", reason_text: ".$response->response_reason_text.", avs_response: ".
            $response->avs_response.", response_string: ".$response->response;

        $this->log($response, 'debug');
        return $retVal;


    }

    public function verifyCardDetails($card, $user, $admin = 0) { // returns 1 on success or the error message on failure
        $this->log("verifyCardDetails", "debug");
        $this->log($card, "debug");

        $authorize_credentials = $this->Authorize->find('first');

        require_once INCLUDE_PATH . 'payments/AuthorizeNet.php';
        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['live_key'], $authorize_credentials['Authorize']['live_secret']);
        } elseif (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'sandbox') {
            $transaction = new AuthorizeNetAIM($authorize_credentials['Authorize']['sandbox_key'], $authorize_credentials['Authorize']['sandbox_secret']);
        }
        $transaction->amount = '0.01';
        $transaction->card_num = $card['Payment_detail']['card_number'];
        $transaction->exp_date = $card['Payment_detail']['year'] . '-' . $card['Payment_detail']['month'];
        $transaction->card_code = $card['Payment_detail']['cvv'];
        $transaction->first_name = $card['Payment_detail']['first_name'];
        $transaction->last_name = $card['Payment_detail']['last_name'];
        $transaction->phone = $user['User']['primary_phone'];
        $transaction->address = $card['Payment_detail']['address'];
        $transaction->city = $card['Payment_detail']['city'];
        $transaction->state = $card['Payment_detail']['state'];
        $transaction->zip = $card['Payment_detail']['zip_code'];
        $transaction->email_customer = "FALSE";
        $transaction->email = $user['User']['email'];

        if($card['Payment_detail']['card_type']=="American Express") {
            //$transaction->amount = '0';
            $transaction->email = $user['User']['email'];
        }
        //$this->log($transaction, "debug");
        if (!empty($authorize_credentials) && $authorize_credentials['Authorize']['mode'] == 'live') {
            $transaction->setSandbox(false);
        }
        $response = $transaction->authorizeOnly();
        //$this->log($response, 'debug');
        if ($response->response_code == "1") {
            $paymentData = array(
                'user_id' => $user['User']['id'],

                'transaction_id' => $response->transaction_id,
                'invoice_number' => $response->invoice_number,
                'card_number' => $card['Payment_detail']['card_number'],
                'exp_month' => $card['Payment_detail']['month'],
                'exp_year' => $card['Payment_detail']['year'],
                'cvv' => $card['Payment_detail']['cvv'],
                'payment_on' => date("m/d/Y", time()),
                'first_name' => $response->first_name,
                'last_name' => $response->last_name,
                'card_type' => $response->card_type,
                'status' => '1',
                'role' => 'auth',
            );



            $this->logActivity($user['User']['id'], "", "", "verifyCardDetails", "verified card", '', "", '', "", $admin, false, "SUCCESS: " . $this->get_auth_response_details($response));
            return 1;

        } else {
            $this->logActivity($user['User']['id'], "", "", "verifyCardDetails", "card failed verification", '', "", '', "", $admin, false, "FAIL: " . $this->get_auth_response_details($response));
            return $response->response_reason_text;

        }

    }

}
