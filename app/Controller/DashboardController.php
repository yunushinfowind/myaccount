<?php

class DashboardController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    var $uses = array('Payment', 'Price', 'Email_content');

    public function webadmin_index() {
        $this->layout = 'admin';
    }

    function secondsToTime($time) { //to convert the time in days, hours and minutes.
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

    public function webadmin_manage_emails() {
        $this->layout = 'admin';
    }

    public function webadmin_forgot_password() { //forgot password for admin.
        $this->layout = 'admin';
        $find = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Forgot Password')));
        $this->set('find', $find);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Email_content->id = $find['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Forgot Password';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['forgot_password'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content added successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_teacher_resend() { //Resend signup details to teacher.
        $this->layout = 'admin';
        $find = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Teacher Resend Details')));
        $this->set('find', $find);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->Email_content->id = $find['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Teacher Resend Details';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['teacher_resend'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content added successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_student_resend() { // Resend signup details to student.
        $this->layout = 'admin';
        $find = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Student Resend Details')));
        $this->set('find', $find);
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Email_content->id = $find['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Student Resend Details';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['student_resend'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content added successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_make_payment() { //Send email whrn payment made for student
        $this->layout = 'admin';
        $find = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Make Payment')));
        $this->set('find', $find);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->Email_content->id = $find['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Make Payment';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['make_payment'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content added successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_student_signup() { //when admin signups the student.
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Student Signup')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->Email_content->id = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Student Signup';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['student_signup'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content added successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_teacher_signup() { //when admin signups teacher.
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Teacher Signup')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->request->data['Email_content']['id'] = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Teacher Signup';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['teacher_signup'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email content updated successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_second_last() { //second to last email send to student on marking lessons complete against the credits in account.
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Second Last')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->request->data['Email_content']['id'] = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Second Last';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['second_last'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email Content updated successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_last() { // last email send to student on marking lessons complete against the credits in account.
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Last')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->request->data['Email_content']['id'] = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Last';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['last'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email Content updated successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_teacher_paid() { //Teacher payment on lessons completed.
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Teacher Paid')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->request->data['Email_content']['id'] = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Teacher Paid';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['teacher_paid'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email Content updated successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

    public function webadmin_message() {
        $this->layout = 'admin';
        $data = $this->Email_content->find('first', array('conditions' => array('Email_content.title' => 'Message Notify')));
        $this->set('data', $data);
        if ($this->request->is('post') || ($this->request->is('put'))) {
            $this->request->data['Email_content']['id'] = $data['Email_content']['id'];
            $this->request->data['Email_content']['title'] = 'Message Notify';
            $this->request->data['Email_content']['content'] = $this->request->data['Email_content']['message'];
            if ($this->Email_content->save($this->request->data)) {
                $this->Session->setFlash(__('Email Content updated successfully.'), 'admin_success');
                $this->redirect(array('controller' => 'dashboard', 'action' => 'manage_emails'));
            }
        }
    }

}
