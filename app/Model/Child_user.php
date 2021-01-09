<?php

class Child_user extends AppModel {

    public $belongsTo = array(
        'User'
    );
    public $validates = array(
        'firstname' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter Students firstname.'
        ),
        'lastname' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter Students lastname.'
        ),
        'age' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please enter Students age.'
        ),
        'subject' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please select Students subject.'
        )
    );

}
