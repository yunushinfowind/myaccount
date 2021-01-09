<?php

class Bank_detail extends AppModel {

    public $validate = array(
        'account_holder_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter Account holder Name.'
        ),
        'account_number' => array(
            'rule' => array('minLength', 17),
            'message' => 'Enter your 17 digits Account Number.'
        ),
        'routing_number' => array(
            'rule' => array('minLength', 16),
            'message' => 'Enter only 16 digits Routing Number.'
        ),
        'account_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Select your Account Type.'
        )
    );

}
