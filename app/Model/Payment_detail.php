<?php

class Payment_detail extends AppModel {

    public $validate = array(
        'name_on_card' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter the Name mentioned on the card.'
        ),
        'card_number' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter the Card Number.'
        ),
        'card_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select Card Type.'
        ),
        'cvv' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter the CVV Number.'
        ),
        'month' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select the month for expiration.'
        ),
        'year' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select the year for expiration.'
        ),
        'first_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your First Name.'
        ),
        'last_name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your Last Name.'
        ),
        'address' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your Address.'
        ),
        'city' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your City.'
        ),
        'state' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your State.'
        ),
        'zip_code' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter your Zip Code.'
        )
    );
//    public $belongsTo = array(
//        'User' => array(
//            'classname' => 'User',
//            'foreignKey' => 'student_id'
//        ),
//    );

}

?>
