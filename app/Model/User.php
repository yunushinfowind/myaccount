<?php

Class User extends AppModel {

    public $validate = array(
        'first_name' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please Enter First Name.'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Please Enter Last Name.'
        ),
        'student_firstname' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please Enter Student First Name.'
        ),
//        'student_lastname' => array(
//            'rule' => 'notEmpty',
//            'required' => false,
//            'message' => 'Please Enter Student Last Name.'
//        ),
        'subject' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter Subject.'
        ),
        'primary_phone' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter your Primary Phone Number.'
        ),
        'email' => array(
            'email' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter your email.'
            ),
            'email1' => array(
                'rule' => array('isUnique'),
                'message' => 'Email already exists.'
            )
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter your address.'
        ),
        'city' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please Enter your City.'
        ),
        'state' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter your State.'
        ),
        'zip_code' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter your Zip Code.'
        ),
        'pricing_type' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please select an pricing Type.'
        ),
        'image' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please upload image.'
        ),
        'credit' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => 'Numbers only'
            ),
        ),
        'hourly_rate' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Add Hourly rate for teacher.'
        ),
        'voilin_price' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Select Violin Price.'
        )
    );
    public $hasOne = array(
        'Teacher_information' => array(
            'classname' => 'Teacher_information',
            'foreignKey' => 'user_id',
            'dependent' => TRUE
        )
    );
    public $hasMany = array(
        'Payment' => array(
            'className' => 'Payment',
            'foreignKey' => 'user_id',
            'dependent' => TRUE
        ),
        'Child_user' => array(
            'className' => 'Child_user',
            'foreign' => 'user_id',
            'dependent' => TRUE
        )
    );

}

?>
