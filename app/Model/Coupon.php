<?php

class Coupon extends AppModel {

    public $validate = array(
        'coupon_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a coupon type.'
        ),
        'coupon_code' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter coupon code.'
        ),
        'discount_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select discount type.'
        ),
        'discount_value' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter value for discount.'
        ),
        'start_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Select an Start date for Coupon.'
        ),
        'end_date' => array(
            'rule' => 'notEmpty',
            'message' => 'Select an End date for Coupon.'
        )
    );

}

?>
