<?php

class TeacherController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $authUser = $this->Auth->User();
        // pr($authUser);
        // $user = $this->Session->read('Auth');
        // pr($user);
        // die('45');
        if (isset($authUser['role']) && ($authUser['role'] == '1')) {
            $this->redirect(BASE_URL);
        }

        $this->Auth->allow(array('purchasePack_cron','calendar'));
    }

    var $uses = array('Scheduler', 'Recurring', 'Subject', 'User', 'Teacher_information', 'Teacher', 'Payment', 'Calendar', 'Message', 'Payment_detail', 'Bank_detail', 'Teacher_earning', 'Recurred_record', 'Admin', 'Assigned_teacher', 'Total_hour', 'Voilin_hour', 'Email_content', 'Paid_teacher', 'Earning', 'Teacher_paid', 'Child_user');

// generate random string of 6 characters.
    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

// adding teacher from admin panel (step1)
    public function webadmin_add() {
        $this->layout = 'admin';
        if ($this->request->is('post')) {
            $email = $this->request->data['User']['email'];
            $find_data = $this->User->find('first', array('conditions' => array('User.email' => $email)));
            $email_data = $this->Email_content->findByTitle('Teacher Signup');
            if (empty($find_data)) {
                if ($this->User->validates()) {
                    $this->request->data['User']['role'] = '2';
                    if ($this->User->save($this->request->data)) {
                        $lastId = $this->User->getLastInsertID();
                        $pwd = $this->generateRandomString();
                        $password = AuthComponent::password($pwd);
                        $token = $this->generateRandomString();
                        $this->User->id = $lastId;
                        $this->User->saveField('password', $password);
                        $user = $this->User->findById($lastId);
                        $Email = $this->getMailerForAddress($user['User']['email']);
                        $Email->template('teacher_signup');
                        $Email->viewVars(array('user' => $user, 'passwords' => $pwd, 'email_data' => $email_data));
                        $Email->to($user['User']['email']);
                        $Email->subject('Successful Sign Up');
                        $Email->send();
                        $this->redirect(BASE_URL . 'webadmin/teacher/add_teacher/' . $lastId);
                    }
                } else {
                    $errors = $this->User->validationErrors;
                }
            } else {
                $this->Session->setFlash('Email already exists, Please signup with new email.', 'error');
            }
        }
    }

//adding teacher from admin panel (step 2)
    public function webadmin_add_teacher($lastId) {
        $this->layout = 'admin';
        $subjects = $this->Subject->find('all', array('order' => array('Subject.order' => 'ASC')));
        $this->set('subjects', $subjects);
        if ($this->request->is('post')) {
            if ($this->Teacher_information->validates()) {
                $this->request->data['Teacher_information']['user_id'] = $lastId;
                if (!empty($this->request->data['Teacher_information']['image']['name']) && isset($this->request->data['Teacher_information']['image']['name'])) {
                    $image = $this->request->data['Teacher_information']['image'];
                    $this->request->data['Teacher_information']['image'] = $this->request->data['Teacher_information']['image']['name'];
                    $this->request->data['Teacher_information']['image'] = time() . '_' . $this->request->data['Teacher_information']['image'];
                    move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/teacher_images/' . $this->request->data['Teacher_information']['image']);
                } else {
                    $this->request->data['Teacher_information']['image'] = '';
                }
                $this->request->data['Teacher_information']['experience'] = $this->request->data['Teacher_information']['exp'] . ' ' . $this->request->data['Teacher_information']['exp_type'];
                if ($this->Teacher_information->save($this->request->data)) {
                    $id = $this->Teacher_information->getLastInsertID();
                    if (isset($this->request->data['Teacher_information']['subject_taught']) && !empty($this->request->data['Teacher_information']['subject_taught'])) {
                        foreach ($this->request->data['Teacher_information']['subject_taught'] as $data) {
                            $teacherData['Teacher']['teacher_information_id'] = $id;
                            $teacherData['Teacher']['subject_id'] = $data;
                            $this->Teacher->create();
                            $this->Teacher->save($teacherData);
                        }
                    }
                    $find = $this->Teacher_information->find('first', array('conditions' => array('Teacher_information.id' => $id)));

                    $this->Session->setFlash('Teacher details added successfully!', 'admin_success');
                    $this->redirect(array('controller' => 'teacher', 'action' => 'index', 'prefix' => 'webadmin'));
                }
            }
        } else {
            $errors = $this->Teacher_information->validationErrors;
        }
    }

// managing added teachers.
    public function webadmin_index() {
        $this->layout = 'admin';
        $FindTeacher = $this->User->find('all', array('conditions' => array('User.role' => '2'), 'order' => array('User.last_name')));
        if (!empty($FindTeacher)) {
            foreach ($FindTeacher as $key => $value) {
                $find = $this->Teacher->find('all', array('conditions' => array('Teacher.teacher_information_id' => $value['Teacher_information']['id'])));
                $FindTeacher[$key]['Subjects'] = $find;
            }
        }
        $this->set('FindTeacher', $FindTeacher);
        $this->render('webadmin_index');
    }

// change status for the added teacher.
    public function webadmin_change_status($id = NULL) {
        // echo $id; die;
        $this->autoRender = FALSE;
        $this->User->recursive = -1;
        $iduser = $this->User->findById($id);
        //  pr($iduser);
        //   die;
        if ($iduser['User']['status'] == '0') {
            $this->User->updateAll(array('User.status' => "1"), array('User.id' => $id));
            $this->Session->setFlash('Status Activated Successfully.', 'admin_success');
        } else {
            $this->User->updateAll(array('User.status' => "0"), array('User.id' => $id));
            $this->Session->setFlash('Status Deactivated Successfully.', 'admin_success');
        }
        $this->redirect(array('controller' => 'teacher', 'action' => 'index', 'prefix' => 'webadmin'));
        //$this->redirect('webadmin/teacher');
    }

// edit step 1 added for teacher (basic info)
    public function webadmin_edit_basic($id = NULL) {
        $this->layout = 'admin';
        $teacher = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        if ($this->request->is('post') or ( $this->request->is('put'))) {
            if ($this->User->validates()) {
                $this->User->id = $id;
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash(__("Teacher's Basic Information edited successfully."), 'admin_success');
                    return $this->redirect(array('action' => 'index'));
                }
            }
        } else {
            $errors = $this->User->validationErrors;
        }
        if (empty($this->request->data)) {
            $this->set('teacher', $teacher);
        }
        $this->set('teacher', $teacher);
    }

// delete teacher details step1  as well as step 2
    public function webadmin_delete_teacher($id = NULL) {
        $this->autoRender = FALSE;
        $this->User->delete($id);
        $this->Session->setFlash('Teacher deleted Successfully.', 'admin_success');
        $this->redirect(array('controller' => 'teacher', 'action' => 'index', 'prefix' => 'webadmin'));
    }

// edit step 2 added for teacher (profile info)
    public function webadmin_edit_profile($id = NULL) {
        $this->layout = 'admin';
        $this->Subject->recursive = -1;
        $subjects = $this->Subject->find('all', array('order' => array('Subject.order' => 'ASC')));


        $teacher = $this->Teacher_information->find('first', array('conditions' => array('Teacher_information.user_id' => $id)));

        $this->set('teacher', $teacher);
        foreach ($subjects as $key => $sub) {
            foreach ($teacher['Teacher'] as $tchr) {
                if ($sub['Subject']['id'] == $tchr['subject_id']) {
                    $subjects[$key]['Subject']['selected'] = 'true';
                }
            }
        }
        $this->set('subjects', $subjects);

        if ($this->request->is('put') || $this->request->is('post')) {
            if (!empty($teacher)) {
                if ($this->request->data['Teacher_information']['image']['name'] != '') {
                    $image = $this->request->data['Teacher_information']['image'];
                    $this->request->data['Teacher_information']['image'] = $this->request->data['Teacher_information']['image']['name'];
                    $this->request->data['Teacher_information']['image'] = time() . '_' . $this->request->data['Teacher_information']['image'];
                    move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/teacher_images/' . $this->request->data['Teacher_information']['image']);
                } elseif (!empty($teacher)) {
                    $this->request->data['Teacher_information']['image'] = $teacher['Teacher_information']['image'];
                }


                if (!empty($this->request->data['Teacher_information']['subject_taught'])) {

                    $conditions = array(
                        'OR' => array(
                            'Teacher.teacher_information_id' => $teacher['Teacher_information']['id'],
                        )
                    );

                    $this->Teacher->deleteAll($conditions);
                    foreach ($this->request->data['Teacher_information']['subject_taught'] as $data) {

                        $teacherData['Teacher']['teacher_information_id'] = $teacher['Teacher_information']['id'];
                        $teacherData['Teacher']['subject_id'] = $data;

                        $this->Teacher->create();
                        $this->Teacher->save($teacherData);
                    }
//                    pr($teacherData);
//                    die;
                }
                $this->request->data['Teacher_information']['experience'] = $this->request->data['Teacher_information']['exp'] . ' ' . $this->request->data['Teacher_information']['exp_type'];

                $this->request->data['Teacher_information']['id'] = $teacher['Teacher_information']['id'];
                $this->Teacher_information->save($this->request->data);
            } else {
                if ($this->request->data['Teacher_information']['image']['name'] != '') {
                    $image = $this->request->data['Teacher_information']['image'];
                    $this->request->data['Teacher_information']['image'] = $this->request->data['Teacher_information']['image']['name'];
                    $this->request->data['Teacher_information']['image'] = time() . '_' . $this->request->data['Teacher_information']['image'];
                    move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/teacher_images/' . $this->request->data['Teacher_information']['image']);
                } else {
                    $this->request->data['Teacher_information']['image'] = '';
                }

                $this->request->data['Teacher_information']['experience'] = $this->request->data['Teacher_information']['exp'] . ' ' . $this->request->data['Teacher_information']['exp_type'];
                $this->request->data['Teacher_information']['user_id'] = $id;

//$this->Teacher_information->create();
                if ($this->Teacher_information->save($this->request->data)) {

                    $get_last_id = $this->Teacher_information->getLastInsertId();

                    if (!empty($this->request->data['Teacher_information']['subject_taught']) && !empty($get_last_id)) {
                        foreach ($this->request->data['Teacher_information']['subject_taught'] as $data) {
                            $teacherData['Teacher']['teacher_information_id'] = $get_last_id['Teacher_information']['id'];
                            $teacherData['Teacher']['subject_id'] = $data;
                        }
                    }
                }
            }
            $this->redirect(array('controller' => 'teacher', 'action' => 'index', 'prefix' => 'webadmin'));
            $this->Session->setFlash("Teacher's Profile information edited successfully.", 'admin_success');
        }
    }

// dashboard or index page of teacher.
    public function index() {
       // pr($_SERVER);
        $this->layout = 'teacher';
        $this->User->recursive = 1;
        $id = $this->Auth->user('id');
        $teacherInfo = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $this->set('teacherInfo', $teacherInfo);
        $calendar = $this->Calendar->find('all', array('conditions' => array('Calendar.teacher_id' => $id, 'Calendar.deleted !=' => 'yes')));
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
                //echo $close_date;
                $get_data = $this->Calendar->find('first', array('conditions' => array('Calendar.teacher_id' => $id, 'Calendar.start_date' => $close_date)));
                if (!empty($get_data) && isset($get_data)) {
                    $this->set('get_data', $get_data);
                    $find_student = $this->User->find('first', array('conditions' => array('User.id' => $get_data['Calendar']['user_id'])));
                    $this->set('find_student', $find_student);
                }
            }
        }
    }

// logout for teacher on front
    public function logout() {
        $this->Session->destroy();
        $this->redirect(BASE_URL);
    }

//profile page of the teacher
    public function profile() {
        $this->layout = 'teacher';
        $authUser = $this->Auth->user();
        $id = $authUser['id'];
        $teacher_basic = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $this->set('teacher_basic', $teacher_basic);
        $teacher_profile = $this->Teacher_information->find('first', array('conditions' => array('Teacher_information.user_id' => $id)));
        $this->set('teacher_profile', $teacher_profile);
        if ($this->request->is('put') || $this->request->is('post')) {
            $admin = $this->Admin->find('first');
            if (!empty($this->request->data['User'])) {
                if ($this->request->data['User']) {
                    if ($this->User->validates()) {


                        $this->User->id = $id;

                        if ($this->User->save($this->request->data['User'])) {
                            $teacher_details = $this->User->findById($id);
                            $Email = $this->getMailerForAddress($admin['Admin']['email']);
                            $Email->template('teacher_profile_updated');
                            $Email->emailFormat('html');
                            $Email->viewVars(array('teacher_details' => $teacher_details, 'admin' => $admin));
                            $Email->from(array($teacher_details['User']['email'] => $teacher_details['User']['first_name'] . ' ' . $teacher_details['User']['last_name']));
                            $Email->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                            $Email->subject('Teacher Profile Updated.');
                            $Email->send();
                            $this->Session->setFlash(__("Teacher's Basic Information edited successfully."), 'success');
                            return $this->redirect(array('action' => 'profile'));
                        }
                    }
                }
            } elseif ($this->request->data['Teacher_information']) {
//                pr($this->request->data);die;
                if (!empty($this->request->data['Teacher_information']['image']['name']) && isset($this->request->data['Teacher_information']['image']['name'])) {
                    $image = $this->request->data['Teacher_information']['image'];
                    $this->request->data['Teacher_information']['image'] = $this->request->data['Teacher_information']['image']['name'];
                    $this->request->data['Teacher_information']['image'] = time() . '_' . $this->request->data['Teacher_information']['image'];
                    move_uploaded_file($image['tmp_name'], INCLUDE_PATH . 'img/teacher_images/' . $this->request->data['Teacher_information']['image']);
                } elseif (!empty($teacher_profile['Teacher_information']['image']) && isset($teacher_profile['Teacher_information']['image'])) {
                    $this->request->data['Teacher_information']['image'] = $teacher_profile['Teacher_information']['image'];
                } else {
                    $this->request->data['Teacher_information']['image'] = '';
                }
                $this->request->data['Teacher_information']['experience'] = $this->request->data['Teacher_information']['exp'] . ' ' . $this->request->data['Teacher_information']['exp_type'];
                if (!empty($teacher_profile)) {
                    $this->request->data['Teacher_information']['id'] = $teacher_profile['Teacher_information']['id'];
                } else {
                    $this->Teacher_information->create();
                    $this->Teacher_information->saveField('user_id', $id);
                }
                if ($this->Teacher_information->save($this->request->data['Teacher_information'])) {
                    $teacher_details = $this->User->findById($id);
                    $Email = $this->getMailerForAddress($admin['Admin']['email']);
                    $Email->template('teacher_profile_updated');
                    $Email->emailFormat('html');
                    $Email->viewVars(array('teacher_details' => $teacher_details, 'admin' => $admin));
                    $Email->from(array($teacher_details['User']['email'] => $teacher_details['User']['first_name'] . ' ' . $teacher_details['User']['last_name']));
                    $Email->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                    $Email->subject('Teacher Profile Updated.');
                    $Email->send();
                    $this->Session->setFlash("Teacher's Profile information edited successfully.", 'success');
                    return $this->redirect(array('action' => 'profile'));
                }
            }
            if (empty($this->request->data['User'])) {
                $this->set('teacher_basic', $teacher_basic);
            }
            if (empty($this->request->data['Teacher_information'])) {
                $this->set('teacher_profile', $teacher_profile);
            }
        }
    }

// messages for teacher on front
    public function messages() {
        $this->layout = 'teacher';
        $all_message = $this->Message->find('all', array('group' => array('Message.send_to'), 'order' => array('Message.id' => 'DESC'), 'conditions' => array('Message.send_by' => $this->Auth->User('id'))));
        if (empty($all_message)) {
            $all_message = $this->Message->find('all', array('group' => array('Message.send_by'), 'order' => array('Message.id' => 'DESC'), 'conditions' => array('Message.send_to' => $this->Auth->User('id'))));
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
                $count_msg = $this->Message->find('count', array(
                    'conditions' => array(
                        'Message.send_by' => $reciever_id,
                        'Message.message_status' => 'unread'
                    )
                        )
                );

                $v = $messages[0];
                if ($v['Message']['send_to'] != $this->Auth->User('id')) {
                    $user = $this->User->findById($v['Message']['send_to']);
                    if (isset($user) && !empty($user)) {
                        $all_message[$keyy]['User'] = $user['User'];
                    }
                } else {
                    $user = $this->User->findById($v['Message']['send_by']);
                    if (!empty($user) && isset($user)) {
                        $all_message[$keyy]['User'] = $user['User'];
                    }
                }
                $all_message[$keyy]['Message'] = $v['Message'];
                $all_message[$keyy]['Count'] = $count_msg;
            }
        }
//        pr($all_message);
//        die;
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

        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $this->Auth->user('id'), 'Assigned_teacher.status' => '1')));
        foreach ($students as $k => $v) {

            $user = $this->User->find('first', array('conditions' => array('User.id' => $v['Assigned_teacher']['student_id'], 'User.status' => '1')));

            if (!empty($user)) {
                $students[$k]['User'] = $user['User'];
            }
        }
        $this->set('students', $students);
    }

// payments history for teacher.
    public function transaction_history() {
        $this->layout = 'teacher';
    }

// students of the teacher 
    public function my_students() {
        $this->layout = 'teacher';
        $this->loadModel('Teacher_information');
        $this->loadModel('Payment');
        $get_id = $this->Auth->user();
        $id = $get_id['id'];
        $get_user = $this->Teacher_information->find('first', array('conditions' => array('Teacher_information.user_id' => $id)));
        $teacher_id = $get_user['Teacher_information']['user_id'];
        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $teacher_id, 'Assigned_teacher.status' => '1')));
        foreach ($students as $key => $student) {

            $get_student = $this->User->find('first', array('conditions' => array('User.id' => $student['Assigned_teacher']['student_id'], 'User.status' => '1')));
            if (!empty($get_student)) {
                $students[$key]['User'] = $get_student['User'];
                $students[$key]['Child_user'] = $get_student['Child_user'];
            }
        }
        $this->set('students', $students);
        $this->Session->write('sessionData', $students);
    }

// details of the student 
    public function student_details($student_id) {
        $this->Session->read('sessionData');
        $this->layout = 'teacher';
        $this->loadModel('User');
        $id = $this->Auth->user('id');
        $this->set('teacher_id', $id);
        $teacher_info = $this->User->find('first', array('conditions' => array('User.id' => $id)));
        $this->set('teacher_info', $teacher_info);

        $calendar = $this->Calendar->find('all', array('conditions' => array('Calendar.teacher_id' => $this->Auth->user('id'), 'Calendar.user_id' => $student_id, 'Calendar.completed_type' => ' ', 'Calendar.deleted !=' => 'yes'), 'fields' => array('id', 'start_date', 'repeat_lesson', 'changed_start')));
        if (!empty($calendar)) {
            foreach ($calendar as $cal) {
                if ($cal['Calendar']['repeat_lesson'] == 'true') {
                    for ($i = 7; $i <= 500; $i += 7) {

                        $changed_date = date('Y-m-d', strtotime('+' . $i . 'days', strtotime($cal['Calendar']['start_date'])));

                        if (strtotime($changed_date . ' ' . $cal['Calendar']['changed_start']) >= time()) {
                            $Dates[] = $changed_date;
                        }
                    }
                } else {
                    $changed_date = date('Y-m-d', strtotime($cal['Calendar']['start_date']));
                    if (strtotime($cal['Calendar']['start_date'] . ' ' . $cal['Calendar']['changed_start']) >= time()) {
                        $Dates[] = $changed_date;
                    } else {
                        $Dates = '';
                    }
                }
                if (isset($Dates[0]) && !empty($Dates)) {
                    $data['id'] = $cal['Calendar']['id'];
                    $data['date'] = $Dates[0];
                }
            }
            if (!empty($data)) {
                $get_data = $this->Calendar->findById($data['id']);

                if (!empty($get_data) && isset($get_data)) {
                    $get_data['Calendar']['start_date'] = $data['date'];
                    $this->set('get_data', $get_data);
                }
            } else {
                $getData = $this->User->findById($student_id);
                $this->set('getData', $getData);
            }
        } else {
            $getData = $this->User->findById($student_id);
            $this->set('getData', $getData);
        }

        $student_info = $this->User->findById($student_id);
        $this->set('student_info', $student_info);
    }

// payment details of the teacher
    public function payment_detail() {
        $this->layout = 'teacher';
        //$this->Calendar->recursive = -1;
        $completd = $this->Calendar->find('all', array('conditions' => array('OR' => array('Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')), 'Calendar.teacher_id' => $this->Auth->user('id'), 'Calendar.deleted' => ''), 'order' => array('Calendar.start_date' => 'ASC')));

        $this->set('completd', $completd);
        $time = 0;

        foreach ($completd as $key => $value) {
            $find_teacher = $this->Assigned_teacher->find('first', array('conditions' => array('Assigned_teacher.teacher_id' => $value['Calendar']['teacher_id'], 'Assigned_teacher.student_id' => $value['Calendar']['user_id'], 'Assigned_teacher.subject_id' => $value['Calendar']['subject'])));
            $teacher_rate = $this->User->findById($value['Calendar']['teacher_id']);
            if (!empty($find_teacher['Assigned_teacher']['special_amount']) && isset($find_teacher['Assigned_teacher']['special_amount'])) {
                $completd[$key]['hourly_rate'] = $find_teacher['Assigned_teacher']['special_amount'] + $teacher_rate['User']['hourly_rate'];
            } else {
                $completd[$key]['hourly_rate'] = $teacher_rate['User']['hourly_rate'];
            }
            $completed_time = $value['Calendar']['schedule_time'];
            if ($completed_time >= '60') {
                $changed_time = $this->secondsToTime($completed_time);
                if (!empty($changed_time['min']) && !empty($changed_time['second'])) {
                    $completd[$key]['converted_time'] = $changed_time['min'] . ' Hours ' . $changed_time['second'] . ' Minutes ';
                } elseif (!empty($changed_time['min']) && empty($changed_time['second'])) {
                    $completd[$key]['converted_time'] = $changed_time['min'] . ' Hours ';
                } elseif (empty($changed_time['min']) && !empty($changed_time['second'])) {
                    $completd[$key]['converted_time'] = $changed_time['second'] . ' Minutes ';
                }
            } else {
                $completd[$key]['converted_time'] = $completed_time . ' Minutes ';
            }
            $time += $completed_time;
        }
        //pr($completd);
        $this->set('completd', $completd);
        if (!empty($completd)) {
            $schedule_earned = 0;
            foreach ($completd as $comp) {
                $schedule_time = $comp['Calendar']['schedule_time'];

                $hourly_rate = $comp['hourly_rate'];
                $schedule_earned += $schedule_time;
            }
            $amount_earned = ($hourly_rate / 60) * $schedule_earned;
            $this->set('amount_earned', $amount_earned);
        }
        if ($time >= 60) {
            $get_time = $this->secondsToTime($time);
            if (!empty($get_time['min']) && !empty($get_time['second'])) {
                $total_earned = $get_time['min'] . ' Hours ' . $get_time['second'] . ' Minutes';
            } elseif (!empty($get_time['min'])) {
                $total_earned = $get_time['min'] . ' Hours ';
            } elseif (!empty($get_time['second'])) {
                $total_earned = $get_time['second'] . ' Minutes ';
            }
        } else {
            $total_earned = $time . ' Minutes';
        }
        $this->set('total_earned', $total_earned);



    }

// Schedule time (Calendar)
    public function calendar() {
        $authUser = $this->Auth->User();
        //pr($authUser);
        $this->layout = 'teacher';
        $this->render = 'teacher/calendar';
        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $this->Auth->User('id'), 'Assigned_teacher.status' => '1')));
        if (!empty($students)) {
            foreach ($students as $key => $student) {
                $get_stu = $this->User->find('first', array('conditions' => array('User.id' => $student['Assigned_teacher']['student_id'], 'User.status' => '1')));
                if (!empty($get_stu)) {
                    $students[$key]['User'] = $get_stu['User'];
                }
            }
            $this->set('students', $students);
        }
        $teacher_earnings = $this->Teacher_earning->findByTeacherId($this->Auth->user('id'));
        //$this->log("Teacher Earnings:", "debug");
        //$this->log($teacher_earnings, "debug");
        if (!empty($teacher_earnings) && isset($teacher_earnings)) {
            $this->set('teacher_earnings', $teacher_earnings);
        }
        $this->render = 'calendar';
    }

// Schedule time (Calendar json)
    public function calendarjson() {
        $this->layout = 'ajax';
        $today = date('M d Y');
        $getMonth = date('m');
        $getYear = date('Y');
        $days = cal_days_in_month('0', $getMonth, $getYear);
        $events = array();
        $j = 0;
        $start = strtotime($_GET['start']);
        $end = strtotime($_GET['end']);
        $datediff = $end - $start;
        $totalDays = floor($datediff / (60 * 60 * 24)) + 1;
        for ($i = 0; $i < $totalDays; $i++) {
            $day = date('Y-m-d', strtotime("+$i days", $start));
            $conditions = array();
            $dayofmonth = date('l', strtotime($day));
            $conditions = array('Calendar.deleted !=' => 'yes');

            $deletedCond = array(
                'Calendar.teacher_id' => $this->Auth->User('id'),
                'Calendar.start_date' => $day,
                'Calendar.deleted' => 'yes',
                'Calendar.parent_id !=' => '0',
            );

            $calendarDeleted = $this->Calendar->find('list', array('conditions' => $deletedCond, 'fields' => array('parent_id')));


            if ($calendarDeleted) {
                $conditions = array('Calendar.id !=' => $calendarDeleted);
            }
            $conditions1 = array(
                'Calendar.teacher_id' => $this->Auth->User('id'),
                'Calendar.start_date' => $day,
                'Calendar.parent_id !=' => '0',
            );

            $calendar1 = $this->Calendar->find('list', array('conditions' => $conditions1, 'fields' => array('parent_id')));

            $conditions['OR'][] = array(
                'Calendar.teacher_id' => $this->Auth->User('id'),
                'Calendar.start_date' => $day,
                'Calendar.deleted' => '',
            );
            $calendar = $this->Calendar->find('list', array('conditions' => $conditions, 'fields' => array('id')));

            $conditions['OR'][] = array(
                'Calendar.teacher_id' => $this->Auth->User('id'),
                'Calendar.repeat_lesson' => 'true',
                'Calendar.dayofmonth' => $dayofmonth,
                'Calendar.deleted' => '',
            );
            if ($calendar1) {
                $conditions['AND'] = array('Calendar.id !=' => $calendar1);
            }
            $calendar = $this->Calendar->find('all', array('conditions' => $conditions));
            if ($calendar) {
                foreach ($calendar as $value) {
                    if ($day >= $value['Calendar']['start_date']) {
                        $events[$j]['title'] = $value['Calendar']['changed_start'] . '-' . $value['Calendar']['changed_end'] . ' ' . ucfirst($value['User']['first_name']) . ' ' . ucfirst($value['User']['last_name']);
                        $events[$j]['start'] = $day . 'T' . date('H:i:s', strtotime($value['Calendar']['time'])) . '-06:00';
                        $events[$j]['end'] = $day . 'T' . date('H:i:s', strtotime($value['Calendar']['end_time'])) . '-06:00';
                        $events[$j]['id'] = $value['Calendar']['id'];

                        if (($value['Calendar']['completed_type'] == 'markcompleted') || ($value['Calendar']['completed_type'] == 'same_day_cancellation') || ($value['Calendar']['completed_type'] == 'student_no_show')) {
                            $events[$j]['borderColor'] = '#42acd1';
                            $events[$j]['backgroundColor'] = '#42acd1';
                        } else {
                            $events[$j]['borderColor'] = "#f47121";
                            $events[$j]['backgroundColor'] = "#f47121";
                        }
                        $j++;
                    }
                }
            }
        }
        if ($events) {
            echo $eventsJson = json_encode($events);
        }
        exit;
    }

    public function webadmin_view_calendar($id = NULL) {
        $this->layout = 'admin';
        $this->loadModel('Calendar');
        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $id, 'Assigned_teacher.status' => '1')));

        $this->Session->write('teacher_id', $id);
        foreach ($students as $k => $student) {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $student['Assigned_teacher']['student_id'], 'User.status' => '1')));
            if (!empty($user['User'])) {
                $students[$k]['User'] = $user['User'];
            }
        }
//        pr($students);die;
        $this->set('students', $students);
    }

    public function message_detail($teacher_id) {
        $this->layout = 'teacher';
        $this->loadModel('User');
        $this->loadModel('Message');
        $get_teacher = $this->User->find('first', array('conditions' => array('User.id' => $teacher_id)));
        $this->set('get_teacher', $get_teacher);
        $cur_user = $this->Auth->user('id');
        $this->set('cur_user', $cur_user);

        $message_to = $this->Message->find('all', array('conditions' => array('Message.send_to' => $teacher_id, 'Message.send_by' => $cur_user)));

        $message_by = $this->Message->find('all', array('conditions' => array('Message.send_by' => $teacher_id, 'Message.send_to' => $cur_user)));
        $messag_thread = array_merge((array) @$message_to, (array) @$message_by);
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
//pr($messag_thread);die;
        $this->set('messag_thread', $messag_thread);
        if ($this->request->is('post')) {
            $to_details = $this->User->findById($this->request->data['Message']['send_to']);
            $by_details = $this->User->findById($this->request->data['Message']['send_by']);

            $email_content = $this->Email_content->findByTitle('Message Notify');
            $this->request->data['Message']['message_status'] = 'unread';
            if ($this->request->data['Message']['file']['name'] != '') {
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
                $url = BASE_URL . 'teacher/message_detail/' . $teacher_id;
                $this->redirect($url);
            }
        }
    }

    public function ajax_completed_lesson() {
        $this->layout = 'ajax';
        $this->loadModel('Payment');
        if (!empty($_POST['paymentId'])) {
            $payment = $this->Payment->findById($_POST['paymentId']);
            $this->set('data', $payment);
        }
        if (!empty($_POST['val']) && !empty($_POST['pay_id'])) {
            $pack['Payment']['completed_lesson'] = $_POST['val'];
            $this->Payment->id = $_POST['pay_id'];
            $this->Payment->save($pack);
        } elseif (empty($_POST['val']) && !empty($_POST['pay_id'])) {
            $pack['Payment']['completed_lesson'] = '';
            $this->Payment->id = $_POST['pay_id'];
            $this->Payment->save($pack);
        }
    }

    public function ajax_closest_student() {
        $this->layout = 'ajax';
        $this->loadModel('User');
        $get_students = $this->User->find('all', array('conditions' => array('User.zip_code' => $_POST['student_zip'])));
        $this->set('get_students', $get_students);
    }

    public function remove_schedule() {
        $this->autoRender = FALSE;
        // pr($_POST);
        $array_value = $_POST['new_array'];
        $start_date = explode('T', $_POST['start_date']);
        $end_date = explode('T', $_POST['end_date']);
        $start_time = explode('-', $start_date[1]);
        $end_time = explode('-', $end_date[1]);
        $time_diff = (strtotime($end_time[0]) - strtotime($start_time[0])) / 60;
        $this->Calendar->recursive = -1;
        $calendar_data = $this->Calendar->findById($_POST['delete_id']);
        $parent_id = $calendar_data['Calendar']['parent_id'];
        if (empty($array_value)) {
            $res['status'] = 'no_data';
            echo json_encode($res);
            die;
        }
        if ($array_value == 'recurring') {
            $this->log('recurring', 'debug');
            if (!empty($parent_id)) {
                $this->log($parent_id, 'debug');
                $data = $this->Calendar->find('list', array('conditions' => array('Calendar.parent_id' => $parent_id, 'OR' => array('Calendar.completed_type NOT LIKE' => 'markcompleted', 'Calendar.id' => $_POST['delete_id'])), 'field' => array('Calendar.id')));
                $this->log($data, 'debug');
                foreach ($data as $key => $val) {
                    $this->Calendar->id = $val;
                    $this->Calendar->saveField('deleted', 'yes');
                    $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == recurring (has parent)");

                }
                $this->Calendar->id = $parent_id;
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == recurring (is parent)");
            } else {
                $data = $this->Calendar->find('list', array('conditions' => array('Calendar.parent_id' => $_POST['delete_id'], 'Calendar.completed_type NOT LIKE' => 'markcompleted'), 'field' => array('Calendar.id')));
                $this->log($data, 'debug');
                foreach ($data as $value) {
                    $this->Calendar->id = $value;
                    $this->Calendar->saveField('deleted', 'yes');
                    $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == recurring (no parent)");
                }
                $this->Calendar->id = $_POST['delete_id'];
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == recurring (delete_id)");
            }
        } elseif ($array_value == 'non_recurring') {
            if ($parent_id != '0') {
                $this->Calendar->id = $_POST['delete_id'];
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == non-recurring (has parent)");
            } else {
                $delete['Calendar']['parent_id'] = $_POST['delete_id'];
                $delete['Calendar']['teacher_id'] = $calendar_data['Calendar']['teacher_id'];
                $delete['Calendar']['user_id'] = $calendar_data['Calendar']['user_id'];
                $delete['Calendar']['subject'] = $calendar_data['Calendar']['subject'];
                $delete['Calendar']['subject_name'] = $calendar_data['Calendar']['subject_name'];
                $delete['Calendar']['start_date'] = date('Y-m-d', strtotime($start_date[0]));
                $delete['Calendar']['end_date'] = date('Y-m-d', strtotime($end_date[0]));
                $delete['Calendar']['time'] = date('H:i:s', strtotime($start_time[0]));
                $delete['Calendar']['end_time'] = date('H:i:s', strtotime($end_time[0]));
                $delete['Calendar']['dayofmonth'] = date('l', strtotime($start_date[0]));
                $delete['Calendar']['changed_start'] = date('h:ia', strtotime($start_time[0]));
                $delete['Calendar']['changed_end'] = date('h:ia', strtotime($end_time[0]));
                $delete['Calendar']['completed_type'] = $calendar_data['Calendar']['completed_type'];
                $delete['Calendar']['completed_remarks'] = $calendar_data['Calendar']['completed_remarks'];
                $delete['Calendar']['repeat_lesson'] = '';
                $delete['Calendar']['schedule_time'] = $time_diff;
                $delete['Calendar']['deleted'] = 'yes';
                $this->Calendar->create();
                $this->Calendar->save($delete);
                $last_id = $this->Calendar->getLastInsertId();
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $last_id, "remove_schedule", "", "", "","", "", false, true, "array_value == non-recurring (created)");
            }
        } elseif ($array_value == 'no_recurring') {
            $this->Calendar->id = $_POST['delete_id'];
            $this->Calendar->saveField('deleted', 'yes');
            $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "remove_schedule", "", "", "","", "", false, true, "array_value == no-recurring");
        }
// Deduct amount from Teacher account 
        //   $time_diff 
        $response = $this->refund($_POST['delete_id']);
        $res['status'] = 'success';
        if (!empty($last_id)) {
            $res['id'] = $last_id;
        }
        echo json_encode($res);
        die;
    }

    public function refund($session_id = NULL) {
        $this->log("refunding lesson: ".$session_id, 'debug' );
        if ($session_id) {
            $get_data = $this->Earning->find('first', array('conditions' => array('Earning.calendar_id' => $session_id)));
            $this->log($get_data, 'debug');
            $cal_record = $this->Calendar->find('first', array('conditions' => array('Calendar.id' => $session_id)));
            if (isset($get_data['Earning']) && !empty($get_data['Earning'])) {
                $teacherID = $get_data['Earning']['teacher_id'];
                $studentId = $get_data['Earning']['user_id'];
                $minutes = $get_data['Earning']['schedule_time'];
                $amt = $get_data['Earning']['amt'];

                //Create inverse earning record
                $new_data['Earning']['user_id'] = $get_data['Earning']['user_id'];
                $new_data['Earning']['teacher_id'] = $get_data['Earning']['teacher_id'];
                $new_data['Earning']['schedule_time'] = $get_data['Earning']['schedule_time'];
                $new_data['Earning']['calendar_id'] = $get_data['Earning']['calendar_id'];
                $new_data['Earning']['amt'] = $get_data['Earning']['amt'] * -1;
                $new_data['Earning']['status'] = 1;
                $new_data['Earning']['earned_date'] = date('Y-m-d H:i:s');
                $this->Earning->create();
                $this->Earning->save($new_data);
                $this->logActivity($studentId, $teacherID, $session_id, "refund", "create inverse earning", $new_data['Earning']['amt'], "$","", "", false, true, "subtracted time: ".$new_data['Earning']['schedule_time']);


                $teacher_data = $this->Teacher_earning->find('first', array('conditions' => array('Teacher_earning.teacher_id' => $teacherID)));
                // deduct from Teacher account 
                $toatal_minutes = (($teacher_data['Teacher_earning']['hour'] * 60) + $teacher_data['Teacher_earning']['minute']) - $minutes;
                $hours = intval($toatal_minutes / 60);  // integer division
                $mins = $toatal_minutes % 60;
                $earned['Teacher_earning']['hour'] = $hours;
                $earned['Teacher_earning']['minute'] = $mins;
                $earned['Teacher_earning']['total_earning'] = $teacher_data['Teacher_earning']['total_earning'] - $amt;
                $this->Teacher_earning->id = $teacher_data['Teacher_earning']['id'];
                $this->Teacher_earning->save($earned);
                $this->logActivity($studentId, $teacherID, $session_id, "refund", "update teacher_earning", -1 * $amt, "$","", "", false, true, "teacher_earning updated.  subtracted time: ".$minutes);

                // Pay to Student
                $user_record = $this->User->find('first', array('conditions' => array('User.id' => $studentId)));

                if($user_record['User']['voilin_price'] == 'Yes' && $cal_record['Calendar']['subject'] == '11') {
                    $Student_data = $this->Voilin_hour->find('first', array('conditions' => array('Voilin_hour.student_id' => $studentId)));
                    $data['Voilin_hour']['total_time'] = $Student_data['Voilin_hour']['total_time'] + $minutes;
                    $this->Voilin_hour->id = $Student_data['Voilin_hour']['id'];
                    $this->Voilin_hour->save($data);

                    $this->logActivity($studentId, $teacherID, $session_id, "refund", "update violin hours", $minutes, "mins","", "", false, true, "violin hours added. new total: ".$data['Voilin_hour']['total_time']);
                } else {

                    $Student_data = $this->Total_hour->find('first', array('conditions' => array('Total_hour.student_id' => $studentId)));

                    $data['Total_hour']['total_time'] = $Student_data['Total_hour']['total_time'] + $minutes;
                    $this->Total_hour->id = $Student_data['Total_hour']['id'];
                    $this->Total_hour->save($data);

                    $this->logActivity($studentId, $teacherID, $session_id, "refund", "update total hours", $minutes, "mins","", "", false, true, "total hours added. new total: ".$data['Total_hour']['total_time']);
                }

                //SEND ADMIN EMAIL
                // for admin
                $admin = $this->Admin->find('first');
                $teacher = $this->User->find('first', array('conditions' => array('User.id' => $teacherID)));
                //$student = $this->User->find('first', array('conditions' => array('User.id' => $studentId)));
                $Email = $this->getMailerForAddress($admin['Admin']['email']);
                $Email->template('refund_lesson');
                $Email->emailFormat('html');
                $Email->viewVars(array('teacher' => $teacher, 'student' => $user_record, 'cal' => $cal_record, 'amt' => $amt, 'minutes' => $minutes, 'admin' => $admin));
                $Email->from(array('contactus@lessonsonthego.com' => 'Lessons On The Go'));
                $Email->to(array($admin['Admin']['email'] => 'Lessons On The Go'));
                $Email->subject('Lesson Refunded');
                $data = $Email->send();
                $this->log($admin['Admin']['email'], 'debug');
                $this->log($data, 'debug');

            }
        }
        return true;
    }

    public function find_data() {
        $this->layout = 'ajax';
        $this->loadModel('Calendar');
        $this->loadModel('Payment');
        $this->Calendar->recursive = -1;
        $get_data = $this->Calendar->findById($_POST['id']);
        $this->set('get_data', $get_data);
//        pr($get_data);die;
        $end_time = $get_data['Calendar']['changed_end'];
        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $this->Auth->user('id'), 'Assigned_teacher.student_id' => $get_data['Calendar']['user_id']), 'group' => array(
                'Assigned_teacher.subject_id')));

        if (!empty($students)) {
            foreach ($students as $key => $student) {
                $user_find = $this->User->findById($student['Assigned_teacher']['student_id']);
                if (!empty($user_find) && $user_find['User']['status'] != "0") {
                    $students[$key]['Student'] = $user_find;
                }
            }
//            pr($students);die;
            $this->set('students', $students);
        }
    }

    public function check_recurring() {
        $this->layout = 'ajax';
        $id = $_POST['getid'];
        $start_date = $_POST['clicked_start'];
        $end_date = $_POST['clicked_end'];
        $recurring = $this->Calendar->find('first', array('conditions' => array('Calendar.id' => $id)));
        $this->set('id', $id);
        $this->set('start_date', $start_date);
        $this->set('end_date', $end_date);
        if (($recurring['Calendar']['repeat_lesson'] == 'true') || ($recurring['Calendar']['parent_id'] != '0')) {
            $this->set('recurred_id', $id);
        }
    }

    public function create_message() {
        $this->autoRender = FALSE;
        if (!empty($_POST['student'])) {
            if (!empty($_POST['comment']) && !empty($_FILES['file'])) {
                $save_messsage['Message']['send_to'] = $_POST['student'];
                $save_messsage['Message']['send_by'] = $this->Auth->user('id');
                $save_messsage['Message']['message'] = $_POST['comment'];
                if (!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])) {
                    $image = WWW_ROOT . 'document/' . time() . '_' . $_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $image);
                    $save_messsage['Message']['file'] = time() . '_' . $_FILES['file']['name'];
                }
                $save_messsage['Message']['message_status'] = 'unread';
            } elseif (!empty($_POST['comment']) && empty($_FILES['file'])) {
                $save_messsage['Message']['send_to'] = $_POST['student'];
                $save_messsage['Message']['send_by'] = $this->Auth->user('id');
                $save_messsage['Message']['message'] = $_POST['comment'];
                $save_messsage['Message']['message_status'] = 'unread';
            } elseif (!empty($_FILES['file']) && empty($_POST['comment'])) {
                $save_messsage['Message']['send_to'] = $_POST['student'];
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

                $Email = $this->getMailerForAddress($to_details['User']['email']);
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

    public function payment_information() {
        $this->layout = 'teacher';
        $user = $this->Auth->user('id');
        $detail = $this->Bank_detail->find('all', array('conditions' => array('Bank_detail.teacher_id' => $user)));
        $this->set('detail', $detail);

        if (empty($detail)) {
            if ($this->request->is('post')) {
                $data = $this->request->data;
                if ($this->Bank_detail->validates()) {
                    for ($i = 0; $i < count($data['Bank_detail']['account_holder_name']); $i++) {
                        $bank_detail['Bank_detail']['teacher_id'] = $user;
                        $bank_detail['Bank_detail']['account_holder_name'] = $data['Bank_detail']['account_holder_name'][$i];
                        $bank_detail['Bank_detail']['account_number'] = base64_encode($data['Bank_detail']['account_number'][$i]);
                        $bank_detail['Bank_detail']['routing_number'] = base64_encode($data['Bank_detail']['routing_number'][$i]);
                        $bank_detail['Bank_detail']['account_type'] = $data['Bank_detail']['account_type'][$i];
                        $bank_detail['Bank_detail']['bank_account'] = $data['Bank_detail']['bank_account'][$i];

                        $this->Bank_detail->create();
                        $this->Bank_detail->save($bank_detail, array('validate' => FALSE));
                    }

                    $this->Session->setFlash(__('Bank detail added succesfully.'), 'success');
                    $this->redirect(array('controller' => 'teacher', 'action' => 'payment_information'));
                }
            } else {
                $errors = $this->Bank_detail->validationErrors;
            }
        } else {
            for ($i = 1; $i <= count($detail); $i++) {
                if ($this->request->is('put') || ($this->request->is('post'))) {
                    $save_data = $this->request->data;
                    $data_id = @$save_data['Bank_detail']['id'];
                    if (isset($data_id)) {
                        $find = $this->Bank_detail->findById($save_data['Bank_detail']['id']);

                        $get_account_pos = strrpos($this->request->data['Bank_detail']['account_number'], '*');
                        $get_routing_pos = strrpos($this->request->data['Bank_detail']['routing_number'], '*');
                        if (isset($get_account_pos) && $get_account_pos != '') {
                            $save_data['Bank_detail']['account_number'] = $find['Bank_detail']['account_number'];
                        } else {
                            $save_data['Bank_detail']['account_number'] = base64_encode($this->request->data['Bank_detail']['account_number']);
                        }

                        if (isset($get_routing_pos) && $get_routing_pos != '') {
                            $save_data['Bank_detail']['routing_number'] = $find['Bank_detail']['routing_number'];
                        } else {
                            $save_data['Bank_detail']['routing_number'] = base64_encode($this->request->data['Bank_detail']['routing_number']);
                        }

                        $id = $this->request->data['Bank_detail']['id'];
                        $this->Bank_detail->id = $id;
                        if ($this->Bank_detail->save($save_data)) {
                            $this->Session->setFlash(__('Bank Details updated successfully.'), 'success');
                            $this->redirect(array('action' => 'payment_information'));
                        }
                    } else {
                        $create_data['Bank_detail']['teacher_id'] = $user;
                        $create_data['Bank_detail']['account_number'] = base64_encode($this->request->data['Bank_detail']['account_number']);
                        $create_data['Bank_detail']['account_holder_name'] = $this->request->data['Bank_detail']['account_holder_name'];
                        $create_data['Bank_detail']['routing_number'] = base64_encode($this->request->data['Bank_detail']['routing_number']);
                        $create_data['Bank_detail']['account_type'] = $this->request->data['Bank_detail']['account_type'];
                        $create_data['Bank_detail']['bank_account'] = $this->request->data['Bank_detail']['bank_account'];
                        $this->Bank_detail->create();
                        if ($this->Bank_detail->save($create_data)) {
                            $this->Session->setFlash(__('Account added succesfully.'), 'success');
                            $this->redirect(array('action' => 'payment_information'));
                        }
                    }
                } else {
                    $errors = $this->Bank_detail->validationErrors;
                }
            }
        }
    }

    function cardMasking($decoded_number, $maskingCharacter = '*') {
        return str_repeat($maskingCharacter, strlen($decoded_number) - 4) . substr($decoded_number, -4);
        return false;
    }

    function cvvMasking($decoded_cvv, $maskingCharacter = '*') {
        return str_repeat($maskingCharacter, strlen($decoded_cvv) - 4) . substr($decoded_cvv, -4);
        return false;
    }

    public function webadmin_completed_lesson($id = NULL) {
        $this->layout = 'admin';
        // $this->Calendar->recursive=-2;
        $find_students = $this->Calendar->find('all', array('conditions' => array('Calendar.teacher_id' => $id, 'Calendar.deleted' => '', 'OR' => array('Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation'))), 'order' => array('Calendar.start_date')));

        // pr($find_students);
        // die;
        $this->set('find_students', $find_students);
    }

    public function scheduled() {

        $this->autoRender = FALSE;
        $student_id = $_POST['student'];
        $teacher_id = $this->Auth->user('id');
        $subject_id = $_POST['subject'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $view = $_POST['view'];
        $getTitle = $_POST['getTitle'];
        $repeat_lesson = $_POST['repeat_lesson'];

        // Do we have all the data we need?
        if (!empty($student_id) && !empty($subject_id) && !empty($start_date) && !empty($end_date)) {
            $time_diff = strtotime($end_time) - strtotime($start_time);
            $time = ($time_diff / 60);
            $subject_get = $this->Subject->findById($subject_id);
            $subject_name = $subject_get['Subject']['subject'];
            $endDate = date('Y-m-d', (strtotime('-1 day', strtotime($end_date))));
            $exploded_start = explode('T', $start_date);
            $exploded_end = explode('T', $end_date);
            $this->Session->write('view', $view);
            $this->Session->write('getTitle', $getTitle);
            $day = date('l', strtotime($start_date));


            $schedule['Calendar']['user_id'] = $student_id;
            $schedule['Calendar']['teacher_id'] = $teacher_id;
            $schedule['Calendar']['subject'] = $subject_id;
            $schedule['Calendar']['subject_name'] = $subject_name;
            if (!empty($exploded_start[1])) {
                $schedule['Calendar']['start_date'] = $exploded_start[0];
            } else {
                $schedule['Calendar']['start_date'] = $start_date;
            }
            $schedule['Calendar']['time'] = date('H:i:s', strtotime($start_time));
            if (!empty($exploded_end[1])) {
                $schedule['Calendar']['end_date'] = $exploded_end[0];
            } else {
                $schedule['Calendar']['end_date'] = $endDate;
            }
            $schedule['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
            $schedule['Calendar']['changed_start'] = date('g:ia', strtotime($start_time));
            $schedule['Calendar']['changed_end'] = date('g:ia', strtotime($end_time));
            $schedule['Calendar']['dayofmonth'] = $day;
            $schedule['Calendar']['schedule_time'] = $time;
            $schedule['Calendar']['repeat_lesson'] = $repeat_lesson;

            // Check for conflicting lesson
            $hasConflict = $this->checkForExistingLessonConflict($schedule);

            //If there's a conflict, return an error
            if($hasConflict['conflict']) {
                $this->log('found conflict, returning error with data: '.json_encode($hasConflict['res']), 'debug');
                echo json_encode($hasConflict['res']);
                die;
            }

            $this->Calendar->create();
            if ($this->Calendar->save($schedule)) {
                $res['suc'] = 'y';
                echo json_encode($res);
                die;
            }

        } else {
            $res['suc'] = 'n';
            echo json_encode($res);
            die;
        }


    }

    public function save_schedule() {
        //   pr($_POST);
        // exit();
        $this->loadModel('Recurred_record');
        $this->autoRender = FALSE;
        $today_data = explode(' ', $_POST['today']);
        $today_date = $today_data[0];
        $today_time = $today_data[1];
        $clicked_event = date('Y-m-d', strtotime($_POST['clicked_date']));
        $title = $_POST['title'];
        $view = $_POST['view'];
        $getTitle = $_POST['getTitle'];
        $repeat_lesson = @$_POST['repeat_lesson'];
        $schedule_id = $_POST['schedule_id'];
        $student = $_POST['student'];
        $subject = $_POST['subject'];
        $subject_name = $_POST['getSubjectName'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $completed_type = $_POST['completed_type'];
        $remarks = trim($_POST['remarks']);
        $start_date = $_POST['start_date'];
        $changed_date = date('Y-m-d', strtotime($start_date));
        $difference = (strtotime($end_time) - strtotime($start_time)) / 60;
        $cal = $this->Calendar->findById($schedule_id);
        $this->Session->write('view', $view);
        $this->Session->write('getTitle', $getTitle);
        $teacher_id = $this->Auth->user('id');
        $today = date('H:i:s', strtotime($today_time));
        $today1 = date('H:i:s', strtotime($end_time));
        $new_today = $today_date . ' ' . $today;
        $old_clicked = $clicked_event . ' ' . $today1;
        $day = date('l', strtotime($start_date));
        $calendar = $this->Calendar->find('first', array('conditions' => array('Calendar.user_id' => $student, 'Calendar.teacher_id' => $teacher_id, 'Calendar.subject' => $subject, 'Calendar.deleted !=' => 'yes', 'Calendar.dayofmonth' => $day)));
//        $calendardata = $this->Calendar->find('all', array('conditions' => array('Calendar.user_id' => $student, 'Calendar.teacher_id' => $teacher_id, 'Calendar.subject' => $subject, 'Calendar.deleted !=' => 'yes', 'Calendar.dayofmonth' => $day)));
//        pr($calendar);
//        die;
        if ((strtotime($new_today) < strtotime($old_clicked)) && (($completed_type == 'markcompleted') || ($completed_type == 'same_day_cancellation') || ($completed_type == 'student_no_show'))) {
            $res['suc'] = 'no';
            echo json_encode($res);
            die;
        }

        $this->log("updating cal: ", 'debug');
        $this->log($cal, 'debug');


        $newCharge = true;

/*
        $this->log($cal['Calendar']['completed_type'], 'debug');
        $this->log(!empty($cal['Calendar']['completed_type']), 'debug');
        $this->log(strlen($cal['Calendar']['completed_type']) > 1, 'debug');
        $this->log($completed_type, 'debug');
        $this->log(!empty($completed_type), 'debug');
        $this->log(strlen($completed_type) > 1, 'debug');
*/



        if(!empty($cal['Calendar']['completed_type']) && strlen($cal['Calendar']['completed_type']) > 1) {
            $this->log('existing lesson already marked complete: '.$cal['Calendar']['completed_type'], 'debug');
            //CHECK PREVIOUS CAL STATUS
            $newCharge = false;
            //$this->refund($cal['Calendar']['id']);
        }


        if ($cal['Calendar']['repeat_lesson'] == 'true') {
            $data['Calendar']['teacher_id'] = $teacher_id;
            $data['Calendar']['parent_id'] = $schedule_id;
            $data['Calendar']['user_id'] = $student;
            $data['Calendar']['subject'] = $subject;
            $data['Calendar']['subject_name'] = $subject_name;
            $data['Calendar']['start_date'] = $changed_date;
            $data['Calendar']['end_date'] = $changed_date;
            $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
            $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
            $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
            $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
            $data['Calendar']['dayofmonth'] = date('l', strtotime($start_date));
            if (!empty($completed_type)) {
                $data['Calendar']['completed_type'] = $completed_type;
            } else {
                $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
            }
            if (!empty($remarks)) {
                $data['Calendar']['completed_remarks'] = $remarks;
            } else {
                $data['Calendar']['completed_remarks'] = trim($cal['Calendar']['completed_remarks']);
            }
            $data['Calendar']['schedule_time'] = $difference;
            $data['Calendar']['repeat_lesson'] = '';

            $this->Calendar->create();
            $this->Calendar->save($data);

            $this->logActivity($student, $teacher_id, $schedule_id, "save_schedule", "", "", "","", "", false, true, "lesson is recurring");
            //CHECK PREVIOUS CAL STATUS
            if ($newCharge && (($data['Calendar']['completed_type'] == 'markcompleted') || ($data['Calendar']['completed_type'] == 'student_no_show') || ($data['Calendar']['completed_type'] == 'same_day_cancellation'))) {
                $session_earning = $this->calculate_earnings($teacher_id, $difference, $student, $subject);
                $getLastId = $this->Calendar->getLastInsertId();
                $this->earned_transactions($data, $getLastId, $session_earning);
            }
        } elseif (($cal['Calendar']['repeat_lesson'] == '') || ($cal['Calendar']['repeat_lesson'] == 'false')) {
            if (!empty($calendar)) {
//                foreach ($calendardata as $calendar) {
                $posted_start = date('H:i:s', strtotime($start_time));
                $posted_end = date('H:i:s', strtotime($end_time));
                $cal_start = date('H:i:s', strtotime($calendar['Calendar']['time']));
                $cal_end = date('H:i:s', strtotime($calendar['Calendar']['end_time']));
                if (isset($schedule_id) && ($repeat_lesson == 'true') && ($calendar['Calendar']['id'] != $schedule_id) && ($cal_start == $posted_start) && ($cal_end == $posted_end)) {
                    $this->Calendar->id = $calendar['Calendar']['id'];
                    $this->Calendar->saveField('deleted', 'yes');
                    $data['Calendar']['teacher_id'] = $teacher_id;
                    $data['Calendar']['user_id'] = $student;
                    $data['Calendar']['subject'] = $subject;
                    $data['Calendar']['start_date'] = $changed_date;
                    $data['Calendar']['end_date'] = $changed_date;
                    $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
                    $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
                    $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
                    $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
                    if (!empty($completed_type)) {
                        $data['Calendar']['completed_type'] = $completed_type;
                    } else {
                        $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
                    }
                    if (!empty($remarks)) {
                        $data['Calendar']['completed_remarks'] = $remarks;
                    } else {
                        $data['Calendar']['completed_remarks'] = trim($cal['Calendar']['completed_remarks']);
                    }
                    $data['Calendar']['schedule_time'] = $difference;
                    if (!empty($repeat_lesson)) {
                        $data['Calendar']['repeat_lesson'] = $repeat_lesson;
                    } else {
                        $data['Calendar']['repeat_lesson'] = $cal['Calendar']['repeat_lesson'];
                    }
                    $this->Calendar->id = $schedule_id;
                    $this->Calendar->save($data);

                    $this->logActivity($student, $teacher_id, $schedule_id, "save_schedule", "", "", "","", "", false, true, "lesson is not recurring, preexisting cal");

                } else {
                    $data['Calendar']['teacher_id'] = $teacher_id;
                    $data['Calendar']['user_id'] = $student;
                    $data['Calendar']['subject'] = $subject;
                    $data['Calendar']['start_date'] = $changed_date;
                    $data['Calendar']['end_date'] = $changed_date;
                    $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
                    $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
                    $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
                    $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
                    if (!empty($completed_type)) {
                        $data['Calendar']['completed_type'] = $completed_type;
                    } else {
                        $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
                    }
                    if (!empty($remarks)) {
                        $data['Calendar']['completed_remarks'] = $remarks;
                    } else {
                        $data['Calendar']['completed_remarks'] = trim($cal['Calendar']['completed_remarks']);
                    }
                    $data['Calendar']['schedule_time'] = $difference;
                    if (!empty($repeat_lesson)) {
                        $data['Calendar']['repeat_lesson'] = $repeat_lesson;
                    } else {
                        $data['Calendar']['repeat_lesson'] = $cal['Calendar']['repeat_lesson'];
                    }
                    $this->Calendar->id = $schedule_id;
                    $this->Calendar->save($data);

                    $this->logActivity($student, $teacher_id, $schedule_id, "save_schedule", "", "", "","", "", false, true, "lesson is not recurring");
                }
                //CHECK PREVIOUS CAL STATUS
                if ($newCharge && ($data['Calendar']['completed_type'] == 'markcompleted' || ($data['Calendar']['completed_type'] == 'student_no_show') || ($data['Calendar']['completed_type'] == 'same_day_cancellation'))) {
                    $session_earning = $this->calculate_earnings($teacher_id, $difference, $student, $subject);
                    $getLastId = $schedule_id;
                    $this->earned_transactions($data, $getLastId, $session_earning);
                }
            }
        }
        $res['suc'] = 'y';
        echo json_encode($res);
        exit();
    }

    public function delete_bank_detail($id = NULL) {
        $this->autoRender = FALSE;
        $this->Bank_detail->delete($id);
        $this->Session->setFlash(__('Bank Details deleted successfully.'), 'success');
        $this->redirect(array
            ('action' => 'payment_information'));
    }

    public function webadmin_calendardata() {
        $this->layout = 'ajax';
        $today = date('M d Y');
        $getMonth = date('m');
        $getYear = date('Y');
        $days = cal_days_in_month('0', $getMonth, $getYear);
        $events = array();
        $j = 0;
        $start = strtotime($_GET['start']);
        $end = strtotime($_GET['end']);
        $teacher_id = $_GET['id'];
        $datediff = $end - $start;
        $totalDays = floor($datediff / (60 * 60 * 24)) + 1;
        for ($i = 0; $i < $totalDays; $i++) {
            $day = date('Y-m-d', strtotime("+$i days", $start));
            $conditions = array();
            $dayofmonth = date('l', strtotime($day));
            $conditions = array('Calendar.deleted !=' => 'yes');


            $deletedCond = array(
                'Calendar.teacher_id' => $teacher_id,
                'Calendar.start_date' => $day,
                'Calendar.deleted' => 'yes',
                'Calendar.parent_id !=' => '0',
            );
            $calendarDeleted = $this->Calendar->find('list', array('conditions' => $deletedCond, 'fields' => array('parent_id')));

            if ($calendarDeleted) {
                $conditions = array('Calendar.id !=' => $calendarDeleted);
            }
            $conditions1 = array(
                'Calendar.teacher_id' => $teacher_id,
                'Calendar.start_date' => $day,
                'Calendar.parent_id !=' => '0',
            );

            $calendar1 = $this->Calendar->find('list', array('conditions' => $conditions1, 'fields' => array('parent_id')));
//            pr($conditions1);die;
            $conditions['OR'][] = array(
                'Calendar.teacher_id' => $teacher_id,
                'Calendar.start_date' => $day,
                'Calendar.deleted' => '',
            );
            $calendar = $this->Calendar->find('list', array('conditions' => $conditions, 'fields' => array('id')));

            $conditions['OR'][] = array(
                'Calendar.teacher_id' => $teacher_id,
                'Calendar.repeat_lesson' => 'true',
                'Calendar.dayofmonth' => $dayofmonth,
                'Calendar.deleted' => '',
            );
            if ($calendar1) {
                $conditions['AND'] = array('Calendar.id !=' => $calendar1);
            }
            $calendar = $this->Calendar->find('all', array('conditions' => $conditions));
            if ($calendar) {
                foreach ($calendar as $value) {

                    if ($day >= $value['Calendar']['start_date']) {
                        $events [$j]['title'] = $value['Calendar'] ['changed_start'] . '-' . $value['Calendar']['changed_end'] . ' ' . ucfirst($value['User']['first_name']) . ' ' . ucfirst($value['User']['last_name']);
                        $events[$j]['start'] = $day . 'T' . date('H:i:s', strtotime($value['Calendar']['time'])) . '-06:00';
                        $events[$j]['end'] = $day . 'T' . date('H:i:s', strtotime($value['Calendar']['end_time'])) . '-06:00';
                        $events[$j]['id'] = $value['Calendar']['id'];
                        $events[$j]['id'] = $value['Calendar']['id'];
                        if ($value['Calendar']['completed_type'] == 'markcompleted' || $value['Calendar']['completed_type'] == 'student_no_show' || $value['Calendar']['completed_type'] == 'same_day_cancellation') {
                            $events[$j]['borderColor'] = '#42acd1';
                            $events[$j]['backgroundColor'] = '#42acd1';
                        } else {
                            $events[$j]['borderColor'] = "#f47121";
                            $events[$j]['backgroundColor'] = "#f47121";
                        }
                        $j++;
                    }
                }
            }
        }
        if ($events) {
            echo $eventsJson = json_encode($events);
        }
        exit;
    }

    public function webadmin_schedule_lesson() {
        $this->autoRender = FALSE;

        // Put POST data into variables
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $getView = $_POST['getView'];
        $student_id = $_POST['student'];
        $getTitle = $_POST['getTitle'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $repeat_lesson = $_POST['repeat_lesson'];
        $subject_id = $_POST['subject'];
        $teacher_id = $_POST['teacherId'];
        //////////

        // If the form doesn't have a teacher, use the logged in user // TODO: maybe not needed?
        if(empty($teacher_id)) {
            $this->log('teacherId empty on form, use logged in teacher: '.$this->Auth->user('id'), 'debug');
            $teacher_id = $this->Auth->user('id');
        } else {
            $this->log('teacherId in form, use for value: '.$_POST['teacherId'], 'debug');
        }
        //////////

        // Do we have all the data we need for this?
        if (!empty($student_id) && !empty($subject_id) && !empty($start_date) && !empty($end_date)) {
            $time = (strtotime($end_time) - strtotime($start_time)) / 60;
            $subject = $this->Subject->findById($subject_id);
            $subject_name = $subject['Subject']['subject'];
            $endDate = date('Y-m-d', (strtotime('-1 day', strtotime($end_date))));
            $exploded_start = explode('T', $start_date);
            $exploded_end = explode('T', $end_date);
            $this->Session->write('view', $getView);
            $this->Session->write('getTitle', $getTitle);
            $day = date('l', strtotime($start_date));


            // Creating new potential schedule object for conflict checking
            $schedule['Calendar']['user_id'] = $student_id;
            $schedule['Calendar']['teacher_id'] = $teacher_id;
            $schedule['Calendar']['subject'] = $subject_id;
            $schedule['Calendar']['subject_name'] = $subject_name;
            if (!empty($exploded_start[1])) {
                $schedule['Calendar']['start_date'] = $exploded_start[0];
            } else {
                $schedule['Calendar']['start_date'] = $start_date;
            }
            $schedule['Calendar']['time'] = date('H:i:s', strtotime($start_time));
            if (!empty($exploded_end[1])) {
                $schedule['Calendar']['end_date'] = $exploded_end[0];
            } else {
                $schedule['Calendar']['end_date'] = $endDate;
            }
            $schedule['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
            $schedule['Calendar']['changed_start'] = date('g:ia', strtotime($start_time));
            $schedule['Calendar']['changed_end'] = date('g:ia', strtotime($end_time));
            $schedule['Calendar']['dayofmonth'] = $day;
            $schedule['Calendar']['schedule_time'] = $time;
            $schedule['Calendar']['repeat_lesson'] = $repeat_lesson;
            //////////////

            // Check for conflicting lesson
            $hasConflict = $this->checkForExistingLessonConflict($schedule);

            //If there's a conflict, return an error
            if($hasConflict['conflict']) {
                $this->log('found conflict, returning error with data: '.json_encode($hasConflict['res']), 'debug');
                echo json_encode($hasConflict['res']);
                die;
            }

            // If we make it this far, everything is good to go, CREATE THE LESSON
            $this->Calendar->create();
            if ($this->Calendar->save($schedule)) {
                $res['suc'] = 'y';
                $res['id'] = $teacher_id;
                echo json_encode($res);
                die;
            }
        } else {
            // Missing data, let the user know
            $res['suc'] = 'n';
            $res['missing'] = true;
            echo json_encode($res);
            die;
        }
    }

    public function webadmin_get_data() {
        $this->layout = 'ajax';
        $this->loadModel('Calendar');
        $this->loadModel('Payment');
        $this->Calendar->recursive = -1;
        $get_data = $this->Calendar->findById($_POST['id']);
        $this->set('get_data', $get_data);
        $teacher_id = $get_data['Calendar']['teacher_id'];
        $end_time = $get_data['Calendar']['changed_end'];

        $students = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $teacher_id), 'group' => 'Assigned_teacher.student_id'));
        if (!empty($students)) {
            foreach ($students as $key => $student) {
                $user_find = $this->User->findById($student['Assigned_teacher']['student_id']);
                if (!empty($user_find) && $user_find['User']['status'] != "0") {
                    $students[$key]['User'] = $user_find['User'];
                }
            }

            $this->set('students', $students);
        }
    }

    public function webadmin_updateScheduledLesson() {
        $this->autoRender = FALSE;
        $today_data = explode(' ', $_POST['today']);
        $today_date = $today_data[0];
        $today_time = $today_data[1];
        $clicked_event = date('Y-m-d', strtotime($_POST['clicked_date']));
        $title = $_POST['title'];
        $view = $_POST['view'];
        $getTitle = $_POST['getTitle'];
        $repeat_lesson = @$_POST['repeat_lesson'];
        $schedule_id = $_POST['schedule_id'];
        $student = $_POST['student'];
        $subject = $_POST['subject'];
        $subject_name = $_POST['getSubjectName'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $completed_type = $_POST['completed_type'];
        $remarks = $_POST['remarks'];
        $start_date = $_POST['start_date'];
        $changed_date = date('Y-m-d', strtotime($start_date));
        $difference = (strtotime($end_time) - strtotime($start_time)) / 60;
        $cal = $this->Calendar->findById($schedule_id);
        $this->Session->write('view', $view);
        $this->Session->write('getTitle', $getTitle);
        $teacher_id = $_POST['teacher_id'];
        $today = date('H:i:s', strtotime($today_time));
        $today1 = date('H:i:s', strtotime($end_time));
        $new_today = $today_date . ' ' . $today;
        $old_clicked = $clicked_event . ' ' . $today1;

        $day = date('l', strtotime($start_date));
        $calendar = $this->Calendar->find('first', array('conditions' => array('Calendar.user_id' => $student, 'Calendar.teacher_id' => $teacher_id, 'Calendar.subject' => $subject, 'Calendar.deleted !=' => 'yes', 'Calendar.dayofmonth' => $day)));
        //$calendardata = $this->Calendar->find('all', array('conditions' => array('Calendar.user_id' => $student, 'Calendar.teacher_id' => $teacher_id, 'Calendar.subject' => $subject, 'Calendar.deleted !=' => 'yes', 'Calendar.dayofmonth' => $day)));

        if ((strtotime($new_today) < strtotime($old_clicked)) && (($completed_type == 'markcompleted') || ($completed_type == 'student_no_show') || ($completed_type == 'same_day_cancellation'))) {
            $res['suc'] = 'no';
            echo json_encode($res);
            die;
        }

        $this->log("admin: updating cal: ", 'debug');
        $this->log($cal, 'debug');

        $newCharge = true;

        if(!empty($cal['Calendar']['completed_type']) && strlen($cal['Calendar']['completed_type']) > 1) {
            $this->log('admin: existing lesson already marked complete: '.$cal['Calendar']['completed_type'], 'debug');
            //CHECK PREVIOUS CAL STATUS
            $newCharge = false;
            //$this->refund($cal['Calendar']['id']);
        }


        if ($cal['Calendar']['repeat_lesson'] == 'true') {
            $data['Calendar']['teacher_id'] = $teacher_id;
            $data['Calendar']['parent_id'] = $schedule_id;
            $data['Calendar']['user_id'] = $student;
            $data['Calendar']['subject'] = $subject;
            $data['Calendar']['subject_name'] = $subject_name;
            $data['Calendar']['start_date'] = $changed_date;
            $data['Calendar']['end_date'] = $changed_date;
            $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
            $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
            $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
            $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
            $data['Calendar']['dayofmonth'] = date('l', strtotime($start_date));
            if (!empty($completed_type)) {
                $data['Calendar']['completed_type'] = $completed_type;
            } else {
                $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
            }
            if (!empty($remarks)) {
                $data['Calendar']['completed_remarks'] = $remarks;
            } else {
                $data['Calendar']['completed_remarks'] = $cal['Calendar']['completed_remarks'];
            }
            $data['Calendar']['schedule_time'] = $difference;
            $data['Calendar']['repeat_lesson'] = '';
            $this->Calendar->create();
            $this->Calendar->save($data);

            //try {
                $this->logActivity($student, $teacher_id, $schedule_id, "webadmin_updateScheduledLesson", "", "", "","", "", true, true, "lesson is recurring");
            //} catch (Exception $e) {
            //    $this->log($e, 'error');
            //}

            //CHECK PREVIOUS CAL STATUS
            if ($newCharge && (($data['Calendar']['completed_type'] == 'markcompleted') || ($data['Calendar']['completed_type'] == 'student_no_show') || ($data['Calendar']['completed_type'] == 'same_day_cancellation'))) {
                $session_earning = $this->calculate_earnings($teacher_id, $difference, $student, $subject);
                $getLastId = $this->Calendar->getLastInsertId();
                $this->earned_transactions($data, $getLastId, $session_earning);
            }
        } elseif (($cal['Calendar']['repeat_lesson'] == '') || ($cal['Calendar']['repeat_lesson'] == 'false')) {
            if (!empty($calendar)) {
                //foreach ($calendardata as $calendar) {
                    $posted_start = date('H:i:s', strtotime($start_time));
                    $posted_end = date('H:i:s', strtotime($end_time));
                    $cal_start = date('H:i:s', strtotime($calendar['Calendar']['time']));
                    $cal_end = date('H:i:s', strtotime($calendar['Calendar'] ['end_time']));
                    if (isset($schedule_id) && ($repeat_lesson == 'true') && ( $calendar['Calendar'] ['id'] != $schedule_id) && ($cal_start == $posted_start) && ($cal_end == $posted_end)) {
                        $this->Calendar->id = $calendar['Calendar']['id'];
                        $this->Calendar->saveField('deleted', 'yes');
                        $data['Calendar']['teacher_id'] = $teacher_id;
                        $data['Calendar']['user_id'] = $student;
                        $data['Calendar']['subject'] = $subject;
                        $data['Calendar']['start_date'] = $changed_date;
                        $data['Calendar']['end_date'] = $changed_date;
                        $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
                        $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
                        $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
                        $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
                        if (!empty($completed_type)) {
                            $data['Calendar']['completed_type'] = $completed_type;
                        } else {
                            $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
                        }
                        if (!empty($remarks)) {
                            $data['Calendar']['completed_remarks'] = $remarks;
                        } else {
                            $data['Calendar']['completed_remarks'] = $cal['Calendar']['completed_remarks'];
                        }
                        $data['Calendar']['schedule_time'] = $difference;
                        if (!empty($repeat_lesson)) {
                            $data['Calendar']['repeat_lesson'] = $repeat_lesson;
                        } else {
                            $data['Calendar']['repeat_lesson'] = $cal['Calendar']['repeat_lesson'];
                        }
                        $this->Calendar->id = $schedule_id;
                        $this->Calendar->save($data);
                        //try {
                            $this->logActivity($student, $teacher_id, $calendar['Calendar']['id'], "webadmin_updateScheduledLesson", "", "", "","", "", true, true, "lesson is not recurring, preexisting cal");
                        //} catch (Exception $e) {
                        //    $this->log($e, 'error');
                        //}

                    } else {
//                        die('2');
                        $data['Calendar']['teacher_id'] = $teacher_id;
                        $data['Calendar']['user_id'] = $student;
                        $data['Calendar']['subject'] = $subject;
                        $data['Calendar']['start_date'] = $changed_date;
                        $data['Calendar']['end_date'] = $changed_date;
                        $data['Calendar']['time'] = date('H:i:s', strtotime($start_time));
                        $data['Calendar']['end_time'] = date('H:i:s', strtotime($end_time));
                        $data['Calendar']['changed_start'] = date('h:ia', strtotime($start_time));
                        $data['Calendar']['changed_end'] = date('h:ia', strtotime($end_time));
                        if (!empty($completed_type)) {
                            $data['Calendar']['completed_type'] = $completed_type;
                        } else {
                            $data['Calendar']['completed_type'] = $cal['Calendar']['completed_type'];
                        }
                        if (!empty($remarks)) {
                            $data['Calendar']['completed_remarks'] = $remarks;
                        } else {
                            $data['Calendar']['completed_remarks'] = $cal['Calendar']['completed_remarks'];
                        }
                        $data['Calendar']['schedule_time'] = $difference;
                        if (!empty($repeat_lesson)) {
                            $data['Calendar']['repeat_lesson'] = $repeat_lesson;
                        } else {
                            $data['Calendar']['repeat_lesson'] = $cal['Calendar']['repeat_lesson'];
                        }
                        $this->Calendar->id = $schedule_id;
                        $this->Calendar->save($data);

                        //try {
                            $this->logActivity($student, $teacher_id, $calendar['Calendar']['id'], "webadmin_updateScheduledLesson", "", "", "","", "", true, true, "lesson is not recurring");
                        //} catch (Exception $e) {
                        //    $this->log($e, 'error');
                        //}

                    }
                    //CHECK PREVIOUS CAL STATUS
                    if ($newCharge && (($data['Calendar']['completed_type'] == 'markcompleted') || ($data['Calendar']['completed_type'] == 'student_no_show') || ($data['Calendar']['completed_type'] == 'same_day_cancellation'))) {
                        $session_earning = $this->calculate_earnings($teacher_id, $difference, $student, $subject);
                        $getLastId = $schedule_id;
                        $this->earned_transactions($data, $getLastId, $session_earning);
                    }

                //}

            }
        }

        $res['suc'] = 'y';
        echo json_encode($res);
        die;
    }

    public function webadmin_check_recurring() {
        $this->layout = 'ajax';
        $id = $_POST['getid'];
        $start_date = $_POST['clicked_start'];
        $end_date = $_POST['clicked_end'];
        $recurring = $this->Calendar->find('first', array('conditions' => array('Calendar.id' => $id)));
        $this->set('id', $id);
        $this->set('start_date', $start_date);
        $this->set('end_date', $end_date);
        if (($recurring['Calendar']['repeat_lesson'] == 'true') || ($recurring['Calendar']['parent_id'] != '0')) {

            $this->set('recurred_id', $id);
        }
    }

    public function webadmin_remove_schedule() {
        // pr($_POST);
        //  die;
        $this->autoRender = FALSE;
        $array_value = $_POST['new_array'];
        $start_date = explode('T', $_POST['start_date']);
        $end_date = explode('T', $_POST['end_date']);
        $start_time = explode('-', $start_date[1]);
        $end_time = explode('-', $end_date [1]);
        $time_diff = (strtotime($end_time[0]) - strtotime($start_time[0])) / 60;
        $this->Calendar->recursive = -1;
        $calendar_data = $this->Calendar->findById($_POST['delete_id']);
        $parent_id = $calendar_data['Calendar']['parent_id'];

        if (empty($array_value)) {
            $res['status'] = 'no_data';
            echo json_encode($res);
            die;
        }

        if ($array_value == 'recurring') {
            if (!empty($parent_id)) {
                $data = $this->Calendar->find('list', array('conditions' => array('Calendar.parent_id' => $parent_id, 'OR' => array('Calendar.completed_type NOT LIKE' => 'markcompleted', 'Calendar.id' => $_POST['delete_id'])), 'field' => array('Calendar.id')));
                foreach ($data as $key => $val) {
                    $this->Calendar->id = $val;
                    $this->Calendar->saveField('deleted', 'yes');
                    $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == recurring (has parent)");
                }
                $this->Calendar->id = $parent_id;
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == recurring (is parent)");
            } else {
                $data = $this->Calendar->find('list', array('conditions' => array('Calendar.parent_id' => $_POST['delete_id'], 'Calendar.completed_type NOT LIKE' => 'markcompleted'), 'field' => array('Calendar.id')));
                foreach ($data as $value) {
                    $this->Calendar->id = $value;
                    $this->Calendar->saveField('deleted', 'yes');
                    $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == recurring (no parent)");

                }
                $this->Calendar->id = $_POST['delete_id'];
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == recurring (delete_id)");

            }
        } elseif ($array_value == 'non_recurring') {
            if ($parent_id != '0') {
                $this->Calendar->id = $_POST['delete_id'];
                $this->Calendar->saveField('deleted', 'yes');
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == non-recurring (has parent)");

            } else {
                $delete['Calendar']['parent_id'] = $_POST['delete_id'];
                $delete['Calendar']['teacher_id'] = $calendar_data['Calendar']['teacher_id'];
                $delete['Calendar']['user_id'] = $calendar_data['Calendar']['user_id'];
                $delete['Calendar']['subject'] = $calendar_data['Calendar']['subject'];
                $delete['Calendar']['subject_name'] = $calendar_data['Calendar']['subject_name'];
                $delete['Calendar']['start_date'] = date('Y-m-d', strtotime($start_date[0]));
                $delete['Calendar']['end_date'] = date('Y-m-d', strtotime($end_date[0]));
                $delete['Calendar']['time'] = date('H:i:s', strtotime($start_time[0]));
                $delete['Calendar']['end_time'] = date('H:i:s', strtotime($end_time[0]));
                $delete['Calendar']['dayofmonth'] = date('l', strtotime($start_date[0]));
                $delete['Calendar']['changed_start'] = date('h:ia', strtotime($start_time[0]));
                $delete['Calendar']['changed_end'] = date('h:ia', strtotime($end_time[0]));
                $delete['Calendar']['completed_type'] = $calendar_data['Calendar']['completed_type'];
                $delete['Calendar']['completed_remarks'] = $calendar_data['Calendar']['completed_remarks'];
                $delete['Calendar']['repeat_lesson'] = '';
                $delete['Calendar']['schedule_time'] = $time_diff;
                $delete['Calendar']['deleted'] = 'yes';
                $this->Calendar->create();
                $this->Calendar->save($delete);
                $last_id = $this->Calendar->getLastInsertId();
                $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $last_id, "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == non-recurring (created)");

            }
        } elseif ($array_value == 'no_recurring') {
            $this->Calendar->id = $_POST['delete_id'];
            $this->Calendar->saveField('deleted', 'yes');
            $this->logActivity($calendar_data['Calendar']['user_id'], $calendar_data['Calendar']['teacher_id'], $calendar_data['Calendar']['id'], "webadmin_remove_schedule", "", "", "","", "", true, true, "array_value == no-recurring");

        }
        $refund = $res['status'] = 'success';
        if (!empty($last_id)) {
            $res['id'] = $last_id;
        }
        $response = $this->refund($_POST['delete_id']);
        echo json_encode($res);
        die;
    }

    public function calculate_earnings($teacher_id, $difference, $student, $subject) {
        $this->log("calculate_earnings: teacher: ".$teacher_id.", difference: ".$difference.", student: ".$student.", subject: ".$subject, 'debug');
        $find_student = $this->User->findById($student);
        $assigned_teacher = $this->Assigned_teacher->find('first', array('conditions' => array('Assigned_teacher.student_id' => $student, 'Assigned_teacher.teacher_id' => $teacher_id, 'Assigned_teacher.subject_id' => $subject)));
        $lesson_duration = $assigned_teacher['Assigned_teacher']['lesson_duration'];
        if ($subject == '11' && $find_student['User']['voilin_price'] == 'Yes') {   //formerly 'Violin'

            $voilin_hours = $this->Voilin_hour->findByStudentId($student);

            if (!empty($voilin_hours)) {
                $final = $voilin_hours['Voilin_hour']['total_time'] - $difference;
                $this->Voilin_hour->id = $voilin_hours['Voilin_hour']['id'];
                $this->Voilin_hour->saveField('total_time', $final);

                $this->logActivity($student, $teacher_id, "", "calculate_earnings", "update violin hours", $difference, "mins","", "", false, true, "violin hours deducted. new total: ".$final);
                //$final1 = round($final / $lesson_duration);
            } else {
                $this->Voilin_hour->create();
                $final = 0 - $difference;
                $save_time['Voilin_hour']['student_id'] = $student;
                $save_time['Voilin_hour']['total_time'] = $final;
                $this->Voilin_hour->save($save_time);

                $this->logActivity($student, $teacher_id, "", "calculate_earnings", "update violin hours", $difference, "mins","", "", false, true, "violin hours created and deducted. new total: ".$final);
                //$final1 = round($final / $lesson_duration);
            }
            $this->sendEmail($student, $final, $subject);

        } else { //formerly 'Violin' then if ($subject != '11')
            $total_hours = $this->Total_hour->findByStudentId($student);
            if (!empty($total_hours)) {
                if ($total_hours['Total_hour']['total_time'] == '0' || $total_hours['Total_hour']['total_time'] == '') {
                    $final = 0 - $difference;
                } else {
                    $final = $total_hours['Total_hour']['total_time'] - $difference;
                }
                $this->Total_hour->id = $total_hours['Total_hour']['id'];
                $this->Total_hour->saveField('total_time', $final);

                $this->logActivity($student, $teacher_id, "", "calculate_earnings", "update total hours", $difference, "mins","", "", false, true, "total hours deducted. new total: ".$final);
            } else {
                $this->Total_hour->create();
                $final = 0 - $difference;
                $save_time['Total_hour']['student_id'] = $student;
                $save_time['Total_hour']['total_time'] = $final;
                $this->Total_hour->save($save_time);

                $this->logActivity($student, $teacher_id, "", "calculate_earnings", "update total hours", $difference, "mins","", "", false, true, "total hours created deducted. new total: ".$final);
            }
            $this->sendEmail($student, $final, $subject);
        }

        $teacher_earned = $this->Teacher_earning->findByTeacherId($teacher_id);
        $find_teacher = $this->User->findById($teacher_id);
        $additional_rate = $this->Assigned_teacher->find('first', array('conditions' => array('Assigned_teacher.student_id' => $student, 'Assigned_teacher.teacher_id' => $teacher_id, 'Assigned_teacher.subject_id' => $subject)));

        if (!empty($additional_rate['Assigned_teacher']['special_amount']) && isset($additional_rate['Assigned_teacher']['special_amount'])) {
            $hour_rate = $find_teacher['User']['hourly_rate'] + $additional_rate['Assigned_teacher']['special_amount'];
        } else {
            $hour_rate = $find_teacher['User'] ['hourly_rate'];
        }
        $earnings = ($hour_rate / 60) * $difference;
        $get_time = $this->secondsToTime($difference);
        if (empty($teacher_earned['Teacher_earning'])) {
            $earned['Teacher_earning']['teacher_id'] = $teacher_id;
            if (!empty($get_time['min'])) {
                $earned['Teacher_earning']['hour'] = $get_time['min'];
            } else {
                $earned['Teacher_earning']['hour'] = '';
            }
            if (!empty($get_time['second'])) {
                $earned['Teacher_earning']['minute'] = $get_time['second'];
            } else {
                $earned['Teacher_earning']['minute'] = '';
            }
            $earned['Teacher_earning']['total_earning'] = $earnings;
            $this->Teacher_earning->create();
            $this->Teacher_earning->save($earned);

            $this->logActivity($student, $teacher_id, "", "calculate_earnings", "create and save teacher_earning", $earnings, "$","", "", false, true, "teacher_earning created and saved.  time: ".$difference);
        } else {
            $already_hour = $teacher_earned['Teacher_earning']['hour'];
            $already_min = $teacher_earned['Teacher_earning']['minute'];
            $already_earning = $teacher_earned['Teacher_earning'] ['total_earning'];
            $total_hour = $already_hour + $get_time['min'];
            $total_minute = $already_min + $get_time['second'];
            if ($total_minute >= 60) {
                $get = $this->secondsToTime($total_minute);
                $earned['Teacher_earning']['hour'] = $get['min'] + $total_hour;
                $earned['Teacher_earning']['minute'] = $get['second'];
            } else {
                $earned['Teacher_earning']['hour'] = $total_hour;
                $earned['Teacher_earning']['minute'] = $total_minute;
            }
            $total_earnings = $already_earning + $earnings;
            $earned['Teacher_earning']['total_earning'] = $total_earnings;
            $this->Teacher_earning->id = $teacher_earned['Teacher_earning']['id'];

            $this->Teacher_earning->save($earned);
            $this->logActivity($student, $teacher_id, "", "calculate_earnings", "update teacher_earning", $earnings, "$","", "", false, true, "teacher_earning updated.  added time: ".$difference);
        }
        return $earnings;
    }

    function secondsToTime($time) {
        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;
        $hourSeconds = $time % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);
        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);
        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);
        $obj = array(
            'hour' => (int) $hours,
            'min' => (int) $minutes,
            'second' =>
            (int) $seconds,
        );

        return $obj;
    }

    public function ajax_get_lesson() {
        $this->autoRender = FALSE;
        $view = $_POST['view'];
        if (($view == 'week') || ($view == 'agendaWeek')) {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $explode);
            $dates = $explode[1];

            $explode_dates = explode('to', $dates[0]);
            if (!empty($explode_dates[1]) && isset($explode_dates[1])) {
                $month = explode(' ', $explode_dates[0]);
                $year = explode(',', $explode_dates[1]);
                $final_month = explode(' ', $year[0]);

                $final_start = "";
                if( strpos($explode_dates[0], ",") !== false ) {
                    $start_date = explode(',', $explode_dates[0]);
                    $start_month = explode(' ', $start_date[0]);
                    $start_year = $start_date[1];

                    $this->log($start_month, "debug");

                    $this->log(trim($start_year) . '-' . $start_month[0] . '-' . $start_month[1], "debug");

                    $final_start = date('Y-m-d', strtotime(trim($start_year) . '-' . $start_month[0] . '-' . $start_month[1]));

                } else {
                    $final_start = date('Y-m-d', strtotime($month[1] . '-' . $month[0] . '-' . $year[1]));
                }

                if (!empty($final_month[2])) {
                    $final_end = date('Y-m-d', strtotime($final_month[2] . '-' . $final_month[1] . '-' . $year[1]));
                } else {
                    $final_end = date('Y-m-d', strtotime($final_month[1] . '-' . $month[0] . '-' . $year[1]));
                }

                $this->log("Final Start:", "debug");
                $this->log($final_start, "debug");
                $this->log("Final End:", "debug");
                $this->log($final_end, "debug");
                $this->log("Final Month:", "debug");
                $this->log($final_month, "debug");

                $conditions = array(
                    'conditions' => array(
                        'and' => array(
                            array('Calendar.start_date >= ' => $final_start,
                                'Calendar.end_date <= ' => $final_end
                            ),
                            'OR' => array(
                                'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                            ), 'and' => array(
                                'Calendar.deleted !=' => array('yes')
                            ),
                            'Calendar.teacher_id' => $this->Auth->user('id')
                )));
                $find_all = $this->Calendar->find('all', $conditions);
                //  $log = $this->Calendar->getDataSource()->getLog(false, false);
                // debug($log);
                $teacher = $this->User->findById($this->Auth->user('id'));
                $hour_rate = $teacher['User'] ['hourly_rate'];
                if (!empty($find_all) && isset($find_all)) {
                    $time = 0;
                    foreach ($find_all as $key => $value) {
                        $time += $value['Calendar']['schedule_time'];
                    }
                    $earnings = ($hour_rate / 60) * $time;
                    $get_time = $this->secondsToTime($time);

                    $res['status'] = 'true';
                    if (!empty($get_time['min']) && !empty($get_time['second'])) {
                        $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                    } elseif (!empty($get_time['min'])) {
                        $res['time'] = $get_time['min'] . 'hr';
                    } elseif (!empty($get_time['second'])) {
                        $res['time'] = $get_time['second'] . 'min';
                    }
                    $res['amount'] = '$ ' . $earnings;
                    echo json_encode($res);
                    die;
                } elseif (empty($find_all)) {
                    $res['status'] = 'false';
                    $res['time'] = '-';
                    $res['amount'] = '-';
                    echo json_encode($res);
                    die;
                }
            }
        }

        if ($view == 'month') {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $date1);
            $dates = $date1[1];
            $date = explode(' ', $dates[0]);
            $dates = $date[0];
            $year = $date[1];
            $final_date = strtotime($dates . $year);
            $start_date = date('Y-m-01', $final_date);
            $end_date = date('Y-m-t', $final_date);
            $conditions = array(
                'conditions' => array(
                    'AND' => array(
                        array('Calendar.start_date >= ' => $start_date,
                            'Calendar.end_date <= ' => $end_date
                        ),
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ), 'and' => array(
                            'Calendar.deleted !=' => array('yes')
                        ),
                        'Calendar.teacher_id' => $this->Auth->user('id')
                    )
                )
            );
            $find_all = $this->Calendar->find('all', $conditions);
            $find_teacher = $this->User->findById($this->Auth->user('id'));

            $hour_rate = $find_teacher ['User']['hourly_rate'];
            if (!empty($find_all) && isset($find_all)) {

                $time = 0;
                foreach ($find_all as $key => $value) {

                    $time += $value['Calendar']['schedule_time'];
                }
                $earnings = ($hour_rate / 60) * $time;
                $get_time = $this->secondsToTime($time);
                $res['status'] = 'true';
                if (!empty($get_time['min']) && !empty($get_time['second'])) {
                    $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                } elseif (!empty($get_time['min'])) {
                    $res['time'] = $get_time['min'] . 'hr';
                } elseif (!empty($get_time['second'])) {
                    $res['time'] = $get_time['second'] . 'min';
                }
                $res['amount'] = '$ ' . $earnings;
                echo json_encode($res);
                die;
            } else {
                $res['status'] = 'false';
                $res['time'] = '-';
                $res['amount'] = '-';
                echo json_encode($res);
                die;
            }
        }

        if ($view == 'day') {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $date1);
            $dates = $date1[1];
            $date = explode(' ', $dates[0]);
            $dates = $date[0];
            $year = $date[1];
            $explode11 = explode(',', $date [1]);
            $aa = $date[0] . '-' . $explode11 [0] . '-' . $date[2];
            $start_date = date('Y-m-d', strtotime($aa));

            $conditions = array(
                'conditions' => array(
                    'and' => array(
                        array('Calendar.start_date' => $start_date,
                            'Calendar.end_date' => $start_date
                        ),
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ), 'and' => array(
                            'Calendar.deleted !=' => array('yes')
                        ),
                        'Calendar.teacher_id' => $this->Auth->user('id'))));
            $find_all = $this->Calendar->find('all', $conditions);
            $teacher_detail = $this->User->findById($this->Auth->user('id'));
            $hour_rate = $teacher_detail ['User']['hourly_rate'];
            if (!empty($find_all) && isset($find_all)) {

                $time = 0;
                foreach ($find_all as $key => $value) {
                    $time += $value['Calendar']['schedule_time'];
                }
                $earnings = ($hour_rate / 60) * $time;
                $get_time = $this->secondsToTime($time);
                $res['status'] = 'true';
                if (!empty($get_time['min']) && !empty($get_time['second'])) {
                    $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                } elseif (!empty($get_time['min'])) {
                    $res['time'] = $get_time['min'] . 'hr';
                } elseif (!empty($get_time['second'])) {
                    $res['time'] = $get_time['second'] . 'min';
                }
                $res['amount'] = '$ ' . $earnings;
                echo json_encode($res);
                die;
            } else {
                $res['status'] = 'false';
                $res['time'] = '-';
                $res['amount'] = '-';
                echo json_encode(
                        $res);
                die;
            }
        }
    }

    public function show_completed() {
        if (empty($teacher_earned['Teacher_earning'])) {
            $earned['Teacher_earning']['teacher_id'] = $teacher_id;
            if (!empty($get_time['min'])) {
                $earned['Teacher_earning']['hour'] = $get_time['min'];
            } else {
                $earned['Teacher_earning']['hour'] = '';
            }
            if (!empty($get_time['second'])) {
                $earned['Teacher_earning']['minute'] = $get_time['second'];
            } else {
                $earned['Teacher_earning']['minute'] = '';
            }
            $earned['Teacher_earning']['total_earning'] = $earnings;
            $this->Teacher_earning->create();
            $this->Teacher_earning->save($earned);
        } else {
            $already_hour = $teacher_earned['Teacher_earning']['hour'];
            $already_min = $teacher_earned['Teacher_earning']['minute'];
            $already_earning = $teacher_earned['Teacher_earning'] ['total_earning'];
            $total_hour = $already_hour + $get_time['min'];
            $total_minute = $already_min + $get_time['second'];
            if ($total_minute >= 60) {
                $get = $this->secondsToTime($total_minute);
                $earned['Teacher_earning']['hour'] = $get['min'] + $total_hour;
                $earned['Teacher_earning']['minute'] = $get['second'];
            } else {
                $earned['Teacher_earning']['hour'] = $total_hour;
                $earned['Teacher_earning']['minute'] = $total_minute;
            }
            $total_earnings = $already_earning + $earnings;
            $earned['Teacher_earning']['total_earning'] = $total_earnings;
            $this->Teacher_earning->id = $teacher_earned['Teacher_earning']['id'];

            $this->Teacher_earning->save($earned);
        }
    }

    public function filter_lesson() {
        $this->layout = 'ajax';
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));
        $conditions = array(
            'conditions' => array(
                'and' => array(
                    array('Calendar.start_date >=' => $start_date,
                        'Calendar.end_date <=' => $end_date
                    ),
                    'Calendar.completed_type' => 'markcompleted',
                    'Calendar.teacher_id' => $this->Auth->user('id')
                )
            ),
            'order' => array('Calendar.start_date')
        );
        $find_lessons = $this->Calendar->find('all', $conditions);

        if (!empty($find_lessons) && isset($find_lessons)) {

            $time1 = 0;
            foreach ($find_lessons as $key => $value) {
                $find_teacher = $this->Assigned_teacher->find('first', array('conditions' => array('Assigned_teacher.teacher_id' => $value['Calendar']['teacher_id'], 'Assigned_teacher.student_id' => $value['Calendar']['user_id'], 'Assigned_teacher.subject_id' => $value['Calendar']['subject'])));

                $teacher_rate = $this->User->findById($value['Calendar']['teacher_id']);
                if (!empty($find_teacher['Assigned_teacher']['special_amount']) && isset($find_teacher['Assigned_teacher']['special_amount'])) {
                    $find_lessons[$key]['hourly_rate'] = $find_teacher['Assigned_teacher']['special_amount'] + $teacher_rate['User']['hourly_rate'];
                } else {
                    $find_lessons[$key]['hourly_rate'] = $teacher_rate['User']['hourly_rate'];
                }
                $time1 += $value['Calendar']['schedule_time'];
            }

            $this->set('find_lessons', $find_lessons);

            if (!empty($find_lessons)) {
                $get_earned = 0;
                foreach ($find_lessons as $all_lessons) {
                    $time_scheduled = $all_lessons['Calendar']['schedule_time'];
                    $hour_rate = $all_lessons['hourly_rate'];
                    $get_earned += $time_scheduled;
                }
                $calculate_earned = ($hour_rate / 60) * $get_earned;
                $this->set('calculate_earned', $calculate_earned);
            }
            //pr($find_lessons);die;
            if ($time1 > 60) {
                $get_time = $this->secondsToTime($time1);
                $this->set('get_time', $get_time);
            } else {

                $this->set('time1', $time1);
            }
        }
    }

    public function webadmin_resend_signup_details($id = NULL) {
        $this->autoRender = FALSE;
        $this->loadModel('Email_content');
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Teacher Resend Details')));
        $find_user = $this->User->findById($id);
        $pwd = $this->generateRandomString();
        $password = AuthComponent::password($pwd);
        $this->User->id = $id;
        $this->User->saveField('password', $password);
        $Email = $this->getMailerForAddress($find_user['User']['email']);
        $Email->template('teacher_resend_signup_details');
        $Email->viewVars(array('find_user' => $find_user, 'new_password' => $pwd, 'data' => $data));
        $Email->to($find_user['User']['email']);
        //$this->log('email subject: '.$data['Email_content']['subject'], 'debug');
        $Email->subject($data['Email_content']['subject']);
        $Email->send();
        $this->Session->setFlash('Sign Up Details sent successfully.', 'admin_success');
        $url = BASE_URL .
                'webadmin/teacher';
        $this->redirect($url);
    }

//    public function sendEmail($student, $final1, $final) {
    public function sendEmail($student, $final, $subject) {
        $admin = $this->Admin->find('first');
        $get_student = $this->User->findById($student);

        if ($subject == '11' && $get_student['User']['voilin_price'] == 'Yes') {  //formerly $subject == 'Violin'
            $second = $get_student['User']['violin_second'];
            $last = $get_student['User']['violin_last'];
        } else {
            $second = $get_student['User']['second_email'];
            $last = $get_student['User']['last_email'];
        }
        $Email = $this->getMailerForAddress($get_student['User']['email']);

        if ($final == $second) {
            $email_data = $this->Email_content->findByTitle('Second Last');
            $Email->template('second_last_lesson');
            $Email->emailFormat('both');
            $Email->viewVars(array('user' => $get_student, 'email_data' => $email_data));
            $Email->to($get_student['User']['email'], $get_student['User']['first_name'] . ' ' . $get_student['User']['last_name']);
            $Email->subject($email_data['Email_content']['subject']);
            $Email->send();
        } elseif ($final <= $last) {
            $emailData = $this->Email_content->findByTitle('Last');

            $Email->template('last_lesson');
            $Email->emailFormat('both');
            $Email->viewVars(array('user' => $get_student, 'emailData' => $emailData));
            $Email->to($get_student['User']['email'], $get_student['User']['first_name'] . ' ' . $get_student['User']['last_name']);
            $Email->subject($emailData['Email_content'][
                    'subject']);
            $Email->send();
            return false;
        }
    }

    public function purchasePack_cron() {
        $this->autoRender = FALSE;
        $this->User->recursive = -1;
        //$date = date('m/d/Y h:i:s a', time());
        //mail('sanjivpnf@gmail.com', 'TestMail', $date);
        // die('here');
        $get_all = $this->Total_hour->find('all', array('conditions' => array('Total_hour.total_time <=' => '0')));
        $emailData = $this->Email_content->findByTitle('Last');
        if (!empty($get_all)) {
            foreach ($get_all as $value) {
                $find_student = $this->User->find('first', array('conditions' => array('User.status' => '1', 'User.id' => $value['Total_hour']['student_id'])));
                if ($find_student) {
                    $Email = $this->getMailerForAddress($find_student['User']['email']);
                    $Email->template('last_lesson');
                    $Email->viewVars(array('user' => $find_student, 'emailData' => $emailData));
                    $Email->to($find_student['User']['email']);
                    $Email->subject($emailData['Email_content']['subject']);
                    $Email->send();
                }
            }
        } else {
            echo 'No Student.';
        }
    }

    public function student_close_me() {
        $this->autoRender = FALSE;
        $teacher_id = $_POST['teacher_id'];
        $student_id = $_POST['student_id'];
        $teacher_info = $this->User->findById($teacher_id);
        $teacher_lat = $teacher_info['User']['latitude'];
        $teacher_lng = $teacher_info['User']['longitude'];
        $assigned = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $teacher_id, 'Assigned_teacher.student_id !=' => $student_id)));
        foreach ($assigned as $get_stu) {
            $stu_id[] = $get_stu['Assigned_teacher']['student_id'];
            $stu_ids = array_values(array_unique($stu_id));
        }

        if (!empty($stu_ids)) {
            foreach ($stu_ids as $k => $v) {
                $d = NULL;
                $lat1 = $teacher_lat;
                $lon1 = $teacher_lng;
                $query = "SELECT  id,address, (3959 * acos(cos(radians('$lat1')) * cos(radians( latitude )) * cos(radians(longitude ) - radians('$lon1')) + sin(radians('$lat1')) * sin(radians(latitude )))) AS distance FROM users WHERE id != '$teacher_id' AND id != '$student_id' AND role='1' ORDER BY distance LIMIT 0 , 10";
                $query_results = $this->User->query($query);
                $rslts = array();
                $rslts1 = array();
                foreach ($query_results as $result) {
                    $calendar = $this->Calendar->find('first', array('conditions' => array('Calendar.teacher_id' => $this->Auth->user('id'), 'Calendar.user_id' => $result['users']['id'], 'Calendar.completed_type' => ' ', 'Calendar.deleted !=' => 'yes')));
                    if (!empty($calendar) && isset($calendar)) {
                        $rslts = $calendar;
                    } elseif (empty($calendar)) {
                        $rslts1[] = $this->User->findById($result['users']['id']);
                    }
                }


                if (!empty($rslts) && isset($rslts)) {
                    $res['suc'] = 'true';
                    $res['stu_id'] = $rslts['User']['id'];
                    $res['address'] = $rslts['User']['address'];
                    $res['name'] = ucfirst($rslts['User']['first_name']) . ' ' . ucfirst($rslts['User']['last_name']);
                    $res['full_address'] = $rslts ['User']['address'] . ',' . $rslts['User']['city'] . ',' . $rslts['User']['state'];
                    $res['phone_number'] = $rslts['User']['primary_phone'];
                    $res['lat'] = $rslts['User']['latitude'];
                    $res['long'] = $rslts['User']['longitude'];
                    if (!empty($rslts['Calendar'])) {
                        $res['subject'] = $rslts['Calendar']['subject_name'];
                        $res['schedule_date'] = date('m/d/Y', strtotime($rslts['Calendar']['start_date'])) . ' ' . $rslts['Calendar']['changed_start'];
                    } elseif (empty($rslts['Calendar'])) {
                        $res['subject'] = '-';
                        $res['schedule_date'] = '-';
                    }
                } elseif (!empty($rslts1) && isset($rslts1)) {
                    $res['suc'] = 'second_case';
                    $res['stu_id'] = $rslts1[0]['User']['id'];
                    $res['address'] = $rslts1[0]['User']['address'];
                    $res ['name'] = ucfirst($rslts1[0]['User']['first_name']) . ' ' . ucfirst($rslts1[0]['User']['last_name']);
                    $res['full_address'] = $rslts1 [0] ['User']['address'] . ',' . $rslts1[0]['User']['city'] . ',' . $rslts1[0]['User']['state'];
                    $res['phone_number'] = $rslts1[0]['User']['primary_phone'];
                    $res['lat'] = $rslts1[0]['User']['latitude'];
                    $res['long'] = $rslts1[0]['User']['longitude'];
                    if (!empty($rslts1['Calendar'])) {
                        $res['subject'] = $rslts1[0]['Calendar']['subject_name'];
                        $res['schedule_date'] = date('m/d/Y', strtotime($rslts1[0]['Calendar']['start_date'])) . ' ' . $rslts1[0]['Calendar']['changed_start'];
                    } elseif (empty($rslts1['Calendar'])) {
                        $res['subject'] = '-';
                        $res['schedule_date'] = '-';
                    }
                } else {
                    $res['suc'] = 'false';
                }
            }
        } else {
            $res['suc'] = 'false';
        }
        echo json_encode($res);
        die;
    }

    public function closest_student() {
        $this->autoRender = FALSE;
        $teacher_id = $_POST['teacher_id'];
        $student_id = $_POST['student_id'];
        $student_details = $this->User->findById($student_id);
        $lat = $student_details['User']['latitude'];
        $lon = $student_details['User']['longitude'];
        $assigned = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.teacher_id' => $teacher_id, 'Assigned_teacher.student_id !=' => $student_id)));
        foreach ($assigned as $get_stu) {
            $stu_id[] = $get_stu['Assigned_teacher']['student_id'];
            $stu_ids = array_values(array_unique($stu_id));
        }
        if (!empty($stu_ids)) {
            foreach ($stu_ids as $k => $v) {
                $closest_student = "SELECT  id,address, (3959 * acos(cos(radians('$lat')) * cos(radians( latitude )) * cos(radians(longitude ) - radians('$lon')) + sin(radians('$lat')) * sin(radians(latitude )))) AS distance FROM users WHERE id != '$teacher_id' AND id != '$student_id' AND role='1' ORDER BY distance LIMIT 0 , 10";
                $query_results = $this->User->query($closest_student);
                $rslts = array();
                $rslts1 = array();
                foreach ($query_results as $result) {
                    $calendar = $this->Calendar->find('first', array('conditions' => array('Calendar.teacher_id' => $this->Auth->user('id'), 'Calendar.user_id' => $result['users']['id'], 'Calendar.completed_type' => ' ', 'Calendar.deleted !=' => 'yes')));
                    if (!empty($calendar) && isset($calendar)) {
                        $rslts = $calendar;
                    } elseif (empty($calendar)) {
                        $rslts1[] = $this->User->findById($result['users']['id']);
                    }
                }


                if (!empty($rslts) && isset($rslts)) {
                    $res['suc'] = 'true';
                    $res['stu_id'] = $rslts['User']['id'];
                    $res['address'] = $rslts['User']['address'];
                    $res['name'] = ucfirst($rslts['User']['first_name']) . ' ' . ucfirst($rslts['User']['last_name']);
                    $res['full_address'] = $rslts ['User']['address'] . ',' . $rslts['User']['city'] . ',' . $rslts['User']['state'];
                    $res['phone_number'] = $rslts['User']['primary_phone'];
                    $res['lat'] = $rslts['User']['latitude'];
                    $res['long'] = $rslts['User']['longitude'];
                    if (!empty($rslts['Calendar'])) {
                        $res['subject'] = $rslts['Calendar']['subject_name'];
                        $res['schedule_date'] = date('m/d/Y', strtotime($rslts['Calendar']['start_date'])) . ' ' . $rslts['Calendar']['changed_start'];
                    } elseif (empty($rslts['Calendar'])) {
                        $res['subject'] = '-';
                        $res['schedule_date'] = '-';
                    }
                } elseif (!empty($rslts1) && isset($rslts1)) {
                    $res['suc'] = 'second_case';
                    $res['stu_id'] = $rslts1[0]['User']['id'];
                    $res['address'] = $rslts1[0]['User']['address'];
                    $res ['name'] = ucfirst($rslts1[0]['User']['first_name']) . ' ' . ucfirst($rslts1[0]['User']['last_name']);
                    $res['full_address'] = $rslts1 [0] ['User']['address'] . ',' . $rslts1[0]['User']['city'] . ',' . $rslts1[0]['User']['state'];
                    $res['phone_number'] = $rslts1[0]['User']['primary_phone'];
                    $res['lat'] = $rslts1[0]['User']['latitude'];
                    $res['long'] = $rslts1[0]['User']['longitude'];
                    if (!empty($rslts1['Calendar'])) {
                        $res['subject'] = $rslts1[0]['Calendar']['subject_name'];
                        $res['schedule_date'] = date('m/d/Y', strtotime($rslts1[0]['Calendar']['start_date'])) . ' ' . $rslts1[0]['Calendar']['changed_start'];
                    } elseif (empty($rslts1['Calendar'])) {
                        $res['subject'] = '-';
                        $res['schedule_date'] = '-';
                    }
                } else {
                    $res['suc'] = 'false';
                }
            }
        } else {
            $res['suc'] = 'false';
        }
        echo json_encode($res);
        die;
    }

    public function get_sub() {
        $this->layout = 'ajax';
        $get = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.student_id' => $_POST['stu_id'], 'Assigned_teacher.teacher_id' => $this->Auth->user('id')), 'group' => array(
                'Assigned_teacher.subject_id')));
        $this->set('get', $get);
    }

    public function webadmin_gt_sub() {
        $this->layout = 'ajax';
        $get = $this->Assigned_teacher->find('all', array('conditions' => array('Assigned_teacher.student_id' => $_POST['stu_id']), 'group' => array(
                'Assigned_teacher.subject_id')));
        $this->set('get', $get);
    }

    public function webadmin_pay($id = NULL) {
        $this->layout = 'admin';
        $Teacher_earning = $this->Teacher_earning->findByTeacherId($id);
        $this->set('Teacher_earning', $Teacher_earning);
        $earnings = $this->Earning->find('all', array('conditions' => array('Earning.teacher_id' => $id, 'Earning.status' => '1')));
        if (!empty($earnings)) {
            foreach ($earnings as $key => $result) {
                $teacher = $this->User->findById($id);
                $hourly_rate = $teacher['User']['hourly_rate'];
                $conditions = array(
                    'conditions' => array(
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.id' => $result['Earning']['calendar_id'],
                        'Calendar.deleted' => '',
                        'Calendar.status' => '1'
                    )
                );
                $calendar = $this->Calendar->find('all', $conditions);

                $student_details = $this->User->find('all', array('conditions' => array('User.id' => $result['Earning']['user_id'])));

                foreach ($calendar as $data) {
                    $convertTime = $this->secondsToTime($data['Calendar']['schedule_time']);
                    if (!empty($convertTime['min']) && !empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['min'] . ' Hours ' . $convertTime['second'] . ' Minutes';
                    } elseif (!empty($convertTime['min']) && empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['min'] . ' Hours';
                    } elseif (empty($convertTime['min']) && !empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['second'] . ' Minutes';
                    }

                    $earnings[$key]['Amount'] = ($data['Calendar']['schedule_time'] / 60) * $hourly_rate;
                    $earnings[$key]['Calendar'] = $data['Calendar'];
                }

                foreach ($student_details as $student) {
                    $earnings[$key]['User'] = $student['User'];
                }
            }
            $this->set('earnings', $earnings);
        }


        if ($this->request->is('post')) {

            if (!empty($this->request->data['Teacher_earning']['amount'])) {
                // Status change for Earnings.
                $calendar_id = explode(',', $this->request->data['Teacher_earning']['calendar_id']);
                if (!empty($Teacher_earning)) {
                    $this->Teacher_earning->id = $Teacher_earning['Teacher_earning']['id'];

                    $total = $Teacher_earning['Teacher_earning']['total_earning'] - $this->request->data['Teacher_earning']['amount'];
                    $this->Teacher_earning->saveField('total_earning', $total);
                } else {
                    $create['Teacher_earning']['teacher_id'] = $Teacher_earning['Teacher_earning']['id'];
                    $create['Teacher_earning']['teacher_id'] = $this->request->data['Teacher_earning']['amount'];
                    $this->Teacher_earning->create($Teacher_earning);
                    $this->Teacher_earning->save($Teacher_earning);
                }

                foreach ($calendar_id as $key => $value) {

                    $this->Calendar->id = $value;
                    $this->Calendar->saveField('status', '0');

                    $earning = $this->Earning->find('all', array('conditions' => array('Earning.calendar_id' => $value)));
                    foreach ($earning as $k => $v) {
                        $this->Earning->id = $v['Earning']['id'];
                        $this->Earning->saveField('status', '0');
                    }
                }


                // for creating row for the paid teachers

                $create['Teacher_paid']['teacher_id'] = $id;
                if (!empty($this->request->data['Teacher_earning']['from_date']) && !empty($this->request->data['Teacher_earning']['to_date'])) {
                    $create['Teacher_paid']['from_date'] = date('Y-m-d', strtotime($this->request->data['Teacher_earning']['from_date']));
                    $create['Teacher_paid']['to_date'] = date('Y-m-d', strtotime($this->request->data['Teacher_earning']['to_date']));
                }
                $create['Teacher_paid']['amount'] = $this->request->data['Teacher_earning']['amount'];
                $create['Teacher_paid']['cleared_on'] = date('Y-m-d');
                $this->Teacher_paid->create();
                $this->Teacher_paid->save($create);
                $this->Session->setFlash(__('Payment made successfully.'), 'success');
            } else {
                $this->Session->setFlash(__('Please enter amount to pay Teacher.'), 'error');
            }
            $url = BASE_URL . 'webadmin/teacher/pay/' . $id;
            $this->redirect($url);
        }
    }

    public function webadmin_update_earnings() {
        $this->autoRender = FALSE;
        $teacher_id = $_POST['teacher_id'];
        $earning = $_POST['totalEarning'];
        $if_exists = $this->Teacher_earning->findByTeacherId($teacher_id);

        if (empty($if_exists)) {
            $save_data['Teacher_earning']['teacher_id'] = $teacher_id;
            $save_data['Teacher_earning']['total_earning'] = $earning;
            $this->Teacher_earning->create();
            $this->Teacher_earning->save($save_data);
        } elseif (!empty($if_exists)) {
            $this->Teacher_earning->id = $if_exists['Teacher_earning']['id'];
            $total_earning = $if_exists['Teacher_earning']['total_earning'] + $earning;
            $this->Teacher_earning->saveField('total_earning', $total_earning);
        }
        $res['status'] = 'success';
        echo json_encode($res);
        die;
    }

    public function earned_transactions($data, $getLastId, $session_earning) {
        $earned['Earning']['calendar_id'] = $getLastId;
        $earned['Earning']['teacher_id'] = $data['Calendar']['teacher_id'];
        $earned['Earning']['user_id'] = $data['Calendar']['user_id'];
        $earned['Earning']['schedule_time'] = $data['Calendar']['schedule_time'];
        $earned['Earning']['amt'] = $session_earning;
        $earned['Earning']['earned_date'] = date('Y-m-d H:i:s');
        $this->Earning->create();
        $this->Earning->save($earned);

        $this->logActivity($data['Calendar']['user_id'], $data['Calendar']['teacher_id'], $getLastId, "earned_transactions", "", $session_earning, "$","", "", false, true, "earned date: ".$earned['Earning']['earned_date']);

    }

    public function webadmin_payroll() {
        $this->layout = 'admin';
        $all_teachers = $this->User->find('all', array('conditions' => array('User.role' => '2')));

        //$this->log($all_teachers, "debug");

        if (!empty($all_teachers)) {
            foreach ($all_teachers as $key => $teacher) {




                $conditions = array(
                    'conditions' => array(
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.teacher_id' => $teacher['User']['id'],
                        'Calendar.status' => '1'
                    )
                );

                $calendar = $this->Calendar->find('all', $conditions);
                $this->log('Teacher: '.$teacher['User']['id'], "debug");
                //$this->log($calendar, 'debug');

                $incomplete_conditions = array(
                    'conditions' => array(
                        'AND' => array(
                            'Calendar.completed_type !=' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.deleted !=' => 'yes',
                        'Calendar.teacher_id' => $teacher['User']['id'],
                        'Calendar.status' => '1'
                    )
                );

                $incomplete_calendar = $this->Calendar->find('all', $incomplete_conditions);
                $this->log('Teacher: '.$teacher['User']['id'], "debug");
                $this->log($incomplete_calendar, "debug");

                if (!empty($calendar) || count($incomplete_calendar) > 0) {
                    $total = 0;

                    if (!empty($calendar)) {
                        foreach ($calendar as $k => $find_time) {

                            $calculate = ($find_time['Calendar']['schedule_time'] / 60) * $teacher['User']['hourly_rate'];
                            $total += $calculate;


                            if ($teacher['User']['id'] == $find_time['Calendar']['teacher_id']) {

                                $all_teachers[$key]['Total_earning'] = $total;

                            }
                        }
                    }

                    if(count($incomplete_calendar) > 0) {
                        $this->log($total, 'debug');
                        if($total == 0) {
                            $all_teachers[$key]['Total_earning'] = $total;
                        }
                            $all_teachers[$key]['incomplete'] = count($incomplete_calendar);
                    }
                }
            }
        }

        $this->set('all_teachers', $all_teachers);
    }

    public function webadmin_pay_all() {
        $this->autoRender = FALSE;
        $this->Calendar->recursive = -1;
        $ids = explode(',', $_POST['ids']);
        $amounts = explode(',', $_POST['amount']);
        if (!empty($_POST['from']) && !empty($_POST['to'])) {
            $from = date('Y-m-d', strtotime($_POST['from']));
            $to = date('Y-m-d', strtotime($_POST['to']));
            if (!empty($ids)) {
                foreach ($ids as $k => $id) {
                    foreach ($amounts as $kk => $amt) {
                        if ($k == $kk) {
                            //$earnings = $this->Earning->find('all', array('conditions' => array('Earning.teacher_id' => $id, 'Earning.status' => '1')));
                            $conditions = array(
                                'conditions' => array(
                                    'OR' => array(
                                        'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                                    ),
                                    'Calendar.teacher_id' => $id,
                                    'Calendar.status' => '1',
                                    'Calendar.start_date >= ' => $from,
                                    'Calendar.end_date <= ' => $to
                                )
                            );

                            $calendar = $this->Calendar->find('all', $conditions);
                            foreach ($calendar as $cal) {
                                $this->Calendar->id = $cal['Calendar']['id'];
                                $this->Calendar->saveField('status', '0');

                                $earnings = $this->Earning->find('all', array('conditions' => array('Earning.calendar_id' => $cal['Calendar']['id'], 'Earning.status' => '1')));
                                foreach($earnings as $earning) {
                                    $this->Earning->id = $earning['Earning']['id'];
                                    $this->Earning->saveField('status', '0');
                                }

                            }

                            $find_earnings = $this->Teacher_earning->findByTeacherId($id);
                            $left_amt = $find_earnings['Teacher_earning']['total_earning'] - $amt;
                            $this->Teacher_earning->id = $find_earnings['Teacher_earning']['id'];
                            $this->Teacher_earning->saveField('total_earning', $left_amt);

                            $teacher_pay['Teacher_paid']['teacher_id'] = $id;

                            $teacher_pay['Teacher_paid']['amount'] = $amt;
                            $teacher_pay['Teacher_paid']['from_date'] = $from;
                            $teacher_pay['Teacher_paid']['to_date'] = $to;
                            $teacher_pay['Teacher_paid']['cleared_on'] = date('Y-m-d');
                            $this->Teacher_paid->create();
                            $this->Teacher_paid->save($teacher_pay);


                            /*
                            $conditions = array('Earning.earned_date BETWEEN ? and ?' => array($from, $to), 'Earning.teacher_id' => $id);

                            $results = $this->Earning->find('all', array(
                                'conditions' => $conditions));
                            foreach ($results as $rslt) {
                                $this->Earning->id = $rslt['Earning']['id'];
                                $this->Earning->saveField('status', '0');
                                $this->Calendar->id = $rslt['Earning']['calendar_id'];
                                $this->Calendar->saveField('status', '0');
                            }

                            $find_earnings = $this->Teacher_earning->findByTeacherId($id);
                            $left_amt = $find_earnings['Teacher_earning']['total_earning'] - $amt;
                            $this->Teacher_earning->id = $find_earnings['Teacher_earning']['id'];
                            $this->Teacher_earning->saveField('total_earning', $left_amt);

                            $teacher_pay['Teacher_paid']['teacher_id'] = $id;

                            $teacher_pay['Teacher_paid']['amount'] = $amt;
                            $teacher_pay['Teacher_paid']['from_date'] = $from;
                            $teacher_pay['Teacher_paid']['to_date'] = $to;
                            $teacher_pay['Teacher_paid']['cleared_on'] = date('Y-m-d');
                            $this->Teacher_paid->create();
                            $this->Teacher_paid->save($teacher_pay);
                            */
                        }
                    }
                }
            }
            $res['status'] = 'success';
        } else {
            if (!empty($ids)) {
                foreach ($ids as $k => $id) {
                    foreach ($amounts as $kk => $amt) {
                        if ($k == $kk) {
                            $conditions = array(
                                'conditions' => array(
                                    'OR' => array(
                                        'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                                    ),
                                    'Calendar.teacher_id' => $id,
                                    'Calendar.status' => '1'
                                )
                            );

                            $calendar = $this->Calendar->find('all', $conditions);

                            foreach ($calendar as $cal) {
                                $this->Calendar->id = $cal['Calendar']['id'];
                                $this->Calendar->saveField('status', '0');
                            }

                            $Earnings = $this->Earning->find('all', array('conditions' => array('Earning.teacher_id' => $id)));
                            foreach ($Earnings as $earning) {
                                $this->Earning->id = $earning['Earning']['id'];
                                $this->Earning->saveField('status', '0');
                            }

                            $find_earnings = $this->Teacher_earning->findByTeacherId($id);
                            $left_amt = $find_earnings['Teacher_earning']['total_earning'] - $amt;
                            $this->Teacher_earning->id = $find_earnings['Teacher_earning']['id'];
                            $this->Teacher_earning->saveField('total_earning', $left_amt);

                            $teacher_pay['Teacher_paid']['teacher_id'] = $id;
                            $teacher_pay['Teacher_paid']['from_date'] = '2017-01-01';
                            $teacher_pay['Teacher_paid']['to_date'] = date('Y-m-d');

                            $teacher_pay['Teacher_paid']['amount'] = $amt;
                            $teacher_pay['Teacher_paid']['cleared_on'] = date('Y-m-d');
                            $this->Teacher_paid->create();
                            $this->Teacher_paid->save($teacher_pay);
                        }
                    }
                }
            }
            $res['status'] = 'success';
        }
        echo json_encode($res);
        die;
    }

    public function webadmin_get_records() {
        $this->layout = 'ajax';
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));
        $teacher_id = $_POST['teacher_id'];
/*
        $conditions = array('Earning.earned_date BETWEEN ? and ?' => array($start_date, $end_date));

        $results = $this->Earning->find('all', array(
            'conditions' => $conditions));
        if (!empty($results)) {
            foreach ($results as $key => $result) {
                $teacher = $this->User->findById($teacher_id);
                $hourly_rate = $teacher['User']['hourly_rate'];

                $conditions = array(
                    'conditions' => array(
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.id' => $result['Earning']['calendar_id'],
                        'Calendar.status' => '1'
                    )
                );
                $calendar = $this->Calendar->find('all', $conditions);


                $student_details = $this->User->find('all', array('conditions' => array('User.id' => $result['Earning']['user_id'])));
                if (!empty($calendar)) {
                    foreach ($calendar as $data) {
                        $convertTime = $this->secondsToTime($data['Calendar']['schedule_time']);
                        if (!empty($convertTime['min']) && !empty($convertTime['second'])) {
                            $results[$key]['Converted_time'] = $convertTime['min'] . ' Hours ' . $convertTime['second'] . ' Minutes';
                        } elseif (!empty($convertTime['min']) && empty($convertTime['second'])) {
                            $results[$key]['Converted_time'] = $convertTime['min'] . ' Hours';
                        } elseif (empty($convertTime['min']) && !empty($convertTime['second'])) {
                            $results[$key]['Converted_time'] = $convertTime['second'] . ' Minutes';
                        }
                        $results[$key]['Amount'] = ($data['Calendar']['schedule_time'] / 60) * $hourly_rate;
                        $results[$key]['Calendar'] = $data['Calendar'];
                    }
                    foreach ($student_details as $student) {
                        $results[$key]['User'] = $student['User'];
                    }
                    if (!empty($data['Calendar'])) {
                        
                    }
                }
            }
        }
   $this->set('results', $results);
*/

        $Teacher_earning = $this->Teacher_earning->findByTeacherId($teacher_id);
        $this->set('Teacher_earning', $Teacher_earning);
        $earnings = $this->Earning->find('all', array('conditions' => array('Earning.teacher_id' => $teacher_id, 'Earning.status' => '1')));
        if (!empty($earnings)) {
            foreach ($earnings as $key => $result) {
                $teacher = $this->User->findById($teacher_id);
                $hourly_rate = $teacher['User']['hourly_rate'];
                $conditions = array(
                    'conditions' => array(
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.teacher_id' => $teacher_id,
                        'Calendar.deleted' => '',
                        'Calendar.status' => '1',
                        'Calendar.start_date >= ' => $start_date,
                        'Calendar.end_date <= ' => $end_date
                    )
                );
                //$this->log($conditions, 'debug');
                $calendar = $this->Calendar->find('all', $conditions);
                //$this->log($calendar, 'debug');


                //$student_details = $this->User->find('all', array('conditions' => array('User.id' => $result['Earning']['user_id'])));
                //$this->log($student_details, 'debug');

                $returnEarnings = array();
                $i = 0;
                foreach ($calendar as $data) {

                    $convertTime = $this->secondsToTime($data['Calendar']['schedule_time']);
                    if (!empty($convertTime['min']) && !empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['min'] . ' Hours ' . $convertTime['second'] . ' Minutes';
                    } elseif (!empty($convertTime['min']) && empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['min'] . ' Hours';
                    } elseif (empty($convertTime['min']) && !empty($convertTime['second'])) {
                        $earnings[$key]['Converted_time'] = $convertTime['second'] . ' Minutes';
                    }

                    $earnings[$key]['Amount'] = ($data['Calendar']['schedule_time'] / 60) * $hourly_rate;
                    $earnings[$key]['Calendar'] = $data['Calendar'];


                    $student = $this->User->find('all', array('conditions' => array('User.id' => $data['Calendar']['user_id'])));
                    $earnings[$key]['User'] = $student[0]['User'];

                    //$this->log($student[0]['User'], 'debug');


                    //foreach ($student_details as $student) {

                      //  $earnings[$key]['User'] = $student['User'];
                    //}

                    array_push($returnEarnings, $earnings[$key]);

                }




            }
            $this->set('earnings', $returnEarnings);
        }

    }

    public function webadmin_find_all_lesson() {
        $this->layout = 'ajax';
        $to = date('Y-m-d', strtotime($_POST['to']));
        $from = date('Y-m-d', strtotime($_POST['from']));
/*
        $conditions = array('conditions' => array('Earning.earned_date BETWEEN ? and ?' => array($from, $to), 'Earning.status' => '1'), 'group' => array('Earning.teacher_id'), 'fields' => array('Earning.teacher_id'));
        $earnings = $this->Earning->find('all', $conditions);


        $condition = array('conditions' => array('Earning.earned_date BETWEEN ? and ?' => array($from, $to), 'Earning.status' => '1'));
        $second = $this->Earning->find('all', $condition);

        if (!empty($earnings)) {

            foreach ($earnings as $key => $earning) {
                $schedule_time = 0;
                foreach ($second as $value) {
                    $teacher = $this->User->findById($earning['Earning']['teacher_id']);
                    if ($value['Earning']['teacher_id'] == $earning['Earning']['teacher_id']) {
                        $cal_idds[] = $value['Earning']['calendar_id'];
                        $calendar_id = implode(',', $cal_idds);
                        $schedule_time += $value['Earning']['schedule_time'];
                    }
                }
                if (!empty($teacher['User'])) {
                    $earnings[$key]['User'] = $teacher['User'];
                    $exact_amt = ($schedule_time / 60) * $teacher['User']['hourly_rate'];
                    $earnings[$key]['Earning']['total_earnings'] = $schedule_time;
                    $earnings[$key]['Earning']['total_amount'] = $exact_amt;
                    $earnings[$key]['Earning']['calendar_id'] = $calendar_id;
                }
            }
        }
*/

        $all_teachers = $this->User->find('all', array('conditions' => array('User.role' => '2')));

        //$this->log($all_teachers, "debug");

        if (!empty($all_teachers)) {
            foreach ($all_teachers as $key => $teacher) {

                $conditions = array(
                    'conditions' => array(
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.teacher_id' => $teacher['User']['id'],
                        'Calendar.status' => '1',
                        /*array(
                            'Earning.earned_date BETWEEN ? and ?' => array($from, $to)
                        )*/
                        'Calendar.start_date >= ' => $from,
                        'Calendar.end_date <= ' => $to

                    )
                );

                //$this->log($conditions, 'debug');

                $calendar = $this->Calendar->find('all', $conditions);
                $this->log('Teacher: '.$teacher['User']['id'], "debug");
                //$this->log($calendar, 'debug');

                $incomplete_conditions = array(
                    'conditions' => array(
                        'AND' => array(
                            'Calendar.completed_type !=' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ),
                        'Calendar.deleted !=' => 'yes',
                        'Calendar.teacher_id' => $teacher['User']['id'],
                        'Calendar.status' => '1',
                        'Calendar.start_date >= ' => $from,
                        'Calendar.end_date <= ' => $to
                    )
                );

                $incomplete_calendar = $this->Calendar->find('all', $incomplete_conditions);
                $this->log('Teacher: '.$teacher['User']['id'], "debug");
                $this->log(count($incomplete_calendar), "debug");
/*
                if (!empty($calendar) || count($incomplete_calendar) > 0) {
                    $total = 0;
                    foreach ($calendar as $k => $find_time) {

                        $calculate = ($find_time['Calendar']['schedule_time'] / 60) * $teacher['User']['hourly_rate'];
                        $total += $calculate;


                        if ($teacher['User']['id'] == $find_time['Calendar']['teacher_id']) {

                            $all_teachers[$key]['Total_earning'] = $total;
                        }
                    }
                }
*/

                if (!empty($calendar) || count($incomplete_calendar) > 0) {
                    $total = 0;

                    if (!empty($calendar)) {
                        foreach ($calendar as $k => $find_time) {

                            $calculate = ($find_time['Calendar']['schedule_time'] / 60) * $teacher['User']['hourly_rate'];
                            $total += $calculate;


                            if ($teacher['User']['id'] == $find_time['Calendar']['teacher_id']) {

                                $all_teachers[$key]['Total_earning'] = $total;

                            }
                        }
                    }

                    if(count($incomplete_calendar) > 0) {
                        $this->log($total, 'debug');
                        if($total == 0) {
                            $all_teachers[$key]['Total_earning'] = $total;
                        }
                        $all_teachers[$key]['incomplete'] = count($incomplete_calendar);
                    }
                }
            }
        }

        $this->set('all_teachers', $all_teachers);
    }

    public function webadmin_ajax_search() {
        $this->layout = 'ajax';
        $conditions = array(
            'OR' => array(
                'User.first_name LIKE' => '%' . $_POST['search'] . '%',
                'User.last_name LIKE' => '%' . $_POST['search'] . '%',
                'User.email LIKE' => '%' . $_POST['search'] . '%',
                'User.primary_phone LIKE' => '%' . $_POST['search'] . '%'
            ),
            'User.role' => '2'
        );
        $this->User->recursive = -1;
        $data = $this->User->find('all', array('conditions' => $conditions));
        $this->set('data', $data);
    }

    public function webadmin_ajax_get_lesson() {

        $this->autoRender = FALSE;
        $view = $_POST['view'];
        $teacher_id = $_POST['teacher'];
        if (($view == 'week') || ($view == 'agendaWeek')) {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $explode);
            $dates = $explode[1];
            $this->log("Dates:", "debug");
            $this->log($explode[1], "debug");


            $explode_dates = explode('to', $dates[0]);
            if (!empty($explode_dates[1]) && isset($explode_dates[1])) {
                $month = explode(' ', $explode_dates[0]);
                $year = explode(',', $explode_dates[1]);
                $final_month = explode(' ', $year[0]);

                $this->log("month", "debug");
                $this->log($month, "debug");
                $this->log("year", "debug");
                $this->log($year, "debug");

                $final_start = "";
                if( strpos($explode_dates[0], ",") !== false ) {
                    $start_date = explode(',', $explode_dates[0]);
                    $start_month = explode(' ', $start_date[0]);
                    $start_year = $start_date[1];

                    $this->log($start_month, "debug");

                    $this->log(trim($start_year) . '-' . $start_month[0] . '-' . $start_month[1], "debug");

                    $final_start = date('Y-m-d', strtotime(trim($start_year) . '-' . $start_month[0] . '-' . $start_month[1]));

                } else {
                    $final_start = date('Y-m-d', strtotime($month[1] . '-' . $month[0] . '-' . $year[1]));
                }



                if (!empty($final_month[2])) {
                    $final_end = date('Y-m-d', strtotime($final_month[2] . '-' . $final_month[1] . '-' . $year[1]));
                } else {
                    $final_end = date('Y-m-d', strtotime($final_month[1] . '-' . $month[0] . '-' . $year[1]));
                }

                $this->log("Final Start:", "debug");
                $this->log($final_start, "debug");
                $this->log("Final End:", "debug");
                $this->log($final_end, "debug");
                $this->log("Final Month:", "debug");
                $this->log($final_month, "debug");


                $conditions = array(
                    'conditions' => array(
                        'and' => array(
                            array('Calendar.start_date >= ' => $final_start,
                                'Calendar.end_date <= ' => $final_end
                            ),
                            'OR' => array(
                                'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                            ), 'and' => array(
                                'Calendar.deleted !=' => array('yes')
                            ),
                            'Calendar.teacher_id' => $teacher_id
                )));
                $find_all = $this->Calendar->find('all', $conditions);
//                $log = $this->Calendar->getDataSource()->getLog(false, false);
//                debug($log);
                $teacher = $this->User->findById($teacher_id);
                $hour_rate = $teacher['User'] ['hourly_rate'];
                if (!empty($find_all) && isset($find_all)) {
                    $time = 0;
                    foreach ($find_all as $key => $value) {
                        $time += $value['Calendar']['schedule_time'];
                    }
                    $earnings = ($hour_rate / 60) * $time;
                    $get_time = $this->secondsToTime($time);

                    $res['status'] = 'true';
                    if (!empty($get_time['min']) && !empty($get_time['second'])) {
                        $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                    } elseif (!empty($get_time['min'])) {
                        $res['time'] = $get_time['min'] . 'hr';
                    } elseif (!empty($get_time['second'])) {
                        $res['time'] = $get_time['second'] . 'min';
                    }
                    $res['amount'] = '$ ' . $earnings;
                    echo json_encode($res);
                    die;
                } elseif (empty($find_all)) {
                    $res['status'] = 'false';
                    $res['time'] = '-';
                    $res['amount'] = '-';
                    echo json_encode($res);
                    die;
                }
            }
        }

        if ($view == 'month') {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $date1);
            $dates = $date1[1];
            $date = explode(' ', $dates[0]);
            $dates = $date[0];
            $year = $date[1];
            $final_date = strtotime($dates . $year);
            $start_date = date('Y-m-01', $final_date);
            $end_date = date('Y-m-t', $final_date);
            $conditions = array(
                'conditions' => array(
                    'AND' => array(
                        array('Calendar.start_date >= ' => $start_date,
                            'Calendar.end_date <= ' => $end_date
                        ),
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ), 'and' => array(
                            'Calendar.deleted !=' => array('yes')
                        ),
                        'Calendar.teacher_id' => $teacher_id
                    )
                )
            );
            $find_all = $this->Calendar->find('all', $conditions);
            $find_teacher = $this->User->findById($teacher_id);

            $hour_rate = $find_teacher ['User']['hourly_rate'];
            if (!empty($find_all) && isset($find_all)) {

                $time = 0;
                foreach ($find_all as $key => $value) {

                    $time += $value['Calendar']['schedule_time'];
                }
                $earnings = ($hour_rate / 60) * $time;
                $get_time = $this->secondsToTime($time);
                $res['status'] = 'true';
                if (!empty($get_time['min']) && !empty($get_time['second'])) {
                    $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                } elseif (!empty($get_time['min'])) {
                    $res['time'] = $get_time['min'] . 'hr';
                } elseif (!empty($get_time['second'])) {
                    $res['time'] = $get_time['second'] . 'min';
                }
                $res['amount'] = '$ ' . $earnings;
                echo json_encode($res);
                die;
            } else {
                $res['status'] = 'false';
                $res['time'] = '-';
                $res['amount'] = '-';
                echo json_encode($res);
                die;
            }
        }

        if ($view == 'day') {
            preg_match_all('#<h2>(.+?)</h2>#', $_POST['centre'], $date1);
            $dates = $date1[1];
            $date = explode(' ', $dates[0]);
            $dates = $date[0];
            $year = $date[1];
            $explode11 = explode(',', $date [1]);
            $aa = $date[0] . '-' . $explode11 [0] . '-' . $date[2];
            $start_date = date('Y-m-d', strtotime($aa));

            $conditions = array(
                'conditions' => array(
                    'and' => array(
                        array('Calendar.start_date' => $start_date,
                            'Calendar.end_date' => $start_date
                        ),
                        'OR' => array(
                            'Calendar.completed_type' => array('student_no_show', 'markcompleted', 'same_day_cancellation')
                        ), 'and' => array(
                            'Calendar.deleted !=' => array('yes')
                        ),
                        'Calendar.teacher_id' => $teacher_id)));
            $find_all = $this->Calendar->find('all', $conditions);
            $teacher_detail = $this->User->findById($teacher_id);
            $hour_rate = $teacher_detail ['User']['hourly_rate'];
            if (!empty($find_all) && isset($find_all)) {

                $time = 0;
                foreach ($find_all as $key => $value) {
                    $time += $value['Calendar']['schedule_time'];
                }
                $earnings = ($hour_rate / 60) * $time;
                $get_time = $this->secondsToTime($time);
                $res['status'] = 'true';
                if (!empty($get_time['min']) && !empty($get_time['second'])) {
                    $res ['time'] = $get_time['min'] . 'hr ' . $get_time['second'] . 'min';
                } elseif (!empty($get_time['min'])) {
                    $res['time'] = $get_time['min'] . 'hr';
                } elseif (!empty($get_time['second'])) {
                    $res['time'] = $get_time['second'] . 'min';
                }
                $res['amount'] = '$ ' . $earnings;
                echo json_encode($res);
                die;
            } else {
                $res['status'] = 'false';
                $res['time'] = '-';
                $res['amount'] = '-';
                echo json_encode($res);
                die;
            }
        }
    }



    protected function lessonTimeOverlaps($startTime, $endTime, $testStart, $testEnd) {
        // Tests if time range overlaps an existing time range
        $testStart = is_int($testStart) ? $testStart : strtotime($testStart); // convert non timestamps
        $testEnd = is_int($testEnd) ? $testEnd : strtotime($testEnd);         // ...
        $startTime = is_int($startTime) ? $startTime : strtotime($startTime); // ...
        $endTime = is_int($endTime) ? $endTime : strtotime($endTime);         // ...
        return (($testStart >= $startTime) && ($testStart < $endTime)) ||     // Proposed start time is after or equal to existing start time AND proposed start time is before existing end time
            (($testEnd > $startTime) && ($testEnd <= $endTime))  ||           // Proposed end time is after existing start time AND proposed end time is before or equal to existing end time
            (($testStart <= $startTime) && ($testEnd >= $endTime))  ||        // Proposed lesson time fully encompasses existing lesson
            (($testStart >= $startTime) && ($testEnd <= $endTime));           // Proposed lesson time is fully within existing lesson
    }

    protected function checkForExistingLessonConflict($calToVerify) {
        $retVal['conflict'] = false;
        $schedule = $calToVerify; //convenience

        $posted_start = $schedule['Calendar']['start_date'];
        $posted_start_time = $schedule['Calendar']['changed_start'];
        $posted_end_time = $schedule['Calendar']['changed_end'];

        $day = $schedule['Calendar']['dayofmonth'];
        $time = $schedule['Calendar']['schedule_time'];
        $repeat_lesson = $schedule['Calendar']['repeat_lesson'];
        $teacher_id = $schedule['Calendar']['teacher_id'];


        // Fetch active lessons for this teacher ( TODO: modify query to no longer pull completed lessons )
        $calendardata = $this->Calendar->find('all', array('conditions' => array('Calendar.teacher_id' => $teacher_id, 'Calendar.deleted !=' => 'yes', 'Calendar.dayofmonth' => $day), 'order' => array('Calendar.id' => 'DESC')));

        //SEV: Debugging
        foreach ($calendardata as $calendar_data) {
            $this->log('checking calendar id: ' . $calendar_data ['Calendar']['id'] . ', student: '.$calendar_data ['Calendar']['user_id'].', teacher: '.$calendar_data ['Calendar']['teacher_id'], 'debug');
        }
        //

        if (!empty($calendardata)) {
            $this->log('existing lesson found for teacher/day combo', 'debug');
            $this->log('new lesson:  check for conflict with existing lesson found for teacher/day combo', 'debug');

            foreach ($calendardata as $calendar_data) {
                $final_start = date('Y-m-d', strtotime($calendar_data['Calendar']['start_date']));
                $final_start_time = date('H:i:s', strtotime($calendar_data['Calendar']['time']));
                $final_end_time = date('H:i:s', strtotime($calendar_data['Calendar']['end_time']));

                $this->log('checking calendar id: ' . $calendar_data ['Calendar']['id'], 'debug');

                if ($repeat_lesson == 'true') {

                    $this->log('new lesson is recurring, checking for conflicts', 'debug');
                    if (($calendar_data ['Calendar']['dayofmonth'] == $day) && ($calendar_data['Calendar']['teacher_id'] == $teacher_id) && ($calendar_data['Calendar']['completed_type'] != 'markcompleted')) {

                        $this->log($calendar_data ['Calendar']['id'] . ': day of week matches, teacher matches, not marked complete', 'debug');

                        if ($final_start >= $posted_start || $calendar_data['Calendar']['repeat_lesson'] == 'true') {
                            $this->log($calendar_data ['Calendar']['id'] . ': date >= proposed date or lesson is recurring', 'debug');

                            if ($this->lessonTimeOverlaps($final_start_time, $final_end_time, $posted_start_time, $posted_end_time)) {
                                $this->log($calendar_data ['Calendar']['id'] . ': time range overlaps proposed range.  Return an error', 'debug');
                                $res['suc'] = 'n';
                                $res['conflict'] = "" . $final_start;

                                $retVal['conflict'] = true;
                                $retVal['res'] = $res;

                                return $retVal;

                            } else {
                                $this->log($calendar_data ['Calendar']['id'] . ': time range DOES NOT overlap proposed range: CONTINUE PROCESSING', 'debug');
                            }
                        }
                    } else {
                        $this->log($calendar_data ['Calendar']['id'] . ': day of week does not match OR student does not match OR teacher does not match OR marked complete: CONTINUE PROCESSING', 'debug');
                    }

                } else {
                    $this->log('new lesson is not recurring, check for conflict', 'debug');

                    $this->log('final_start: '.$final_start.', posted_start: '.$posted_start.", existing lesson repeating?: ".$calendar_data['Calendar']['repeat_lesson'], 'debug');

                    if($final_start == $posted_start || ($final_start <= $posted_start && $calendar_data['Calendar']['repeat_lesson'] == 'true')) {
                        $this->log('lessons are on the same day OR (date <= proposed date AND old lesson is recurring), check for conflict ', 'debug');

                        $deletedRecurring = $this->Calendar->find('first', array('conditions' => array('Calendar.teacher_id' => $teacher_id, 'Calendar.deleted =' => 'yes', 'Calendar.dayofmonth' => $day, 'Calendar.start_date' => $posted_start, 'Calendar.parent_id' => $calendar_data['Calendar']['id']), 'order' => array('Calendar.id' => 'DESC')));


                        if($deletedRecurring) {
                            $temp_start_time = date('H:i:s', strtotime($deletedRecurring['Calendar']['time']));
                            $temp_end_time = date('H:i:s', strtotime($deletedRecurring['Calendar']['end_time']));
                        }

                        //$this->log($deletedRecurring['Calendar']['time'], 'debug');
                        //$this->log($deletedRecurring['Calendar']['end_time'], 'debug');
                        //$this->log($this->lessonTimeOverlaps($temp_start_time, $temp_end_time, $posted_start_time, $posted_end_time),'debug');
                        if ($deletedRecurring && $this->lessonTimeOverlaps($temp_start_time, $temp_end_time, $posted_start_time, $posted_end_time)) {
                            $this->log('found recurring lesson conflict, but instance was deleted, OK to continue: CONTINUE PROCESSING', 'debug');

                        } else if ($this->lessonTimeOverlaps($final_start_time, $final_end_time, $posted_start_time, $posted_end_time)) {
                            $this->log($calendar_data ['Calendar']['id'] . ': time range overlaps proposed range.  Return an error', 'debug');
                            $res['suc'] = 'n';
                            $res['conflict'] = "" . $final_start;

                            $retVal['conflict'] = true;
                            $retVal['res'] = $res;

                            return $retVal;

                        } else {
                            $this->log($calendar_data ['Calendar']['id'] . ': time range DOES NOT overlap proposed range: CONTINUE PROCESSING', 'debug');
                        }

                    }
                }

            }

        } else {
            $this->log('existing lessons NOT found for teacher/day combo: OK TO CREATE LESSON', 'debug');
        }

        $this->log("Done making sure there wasn't a conflict: OK TO CREATE LESSON", 'debug');

        return $retVal;


    }

}
