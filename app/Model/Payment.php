<?php

class Payment extends AppModel {

    public $belongsTo = array(
        'User', 'Subject'
    );
    public $validate = array(
        'detail_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select Card.'
        ),
         'subject' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select subject.'
        ),
        'pack' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select Package Price.'
        ),
        'amount' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter amount.'
        )       
    );

}

?>
