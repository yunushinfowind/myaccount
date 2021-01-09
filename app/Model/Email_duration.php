<?php

class Email_duration extends AppModel {

    public $validate = array(
        'second' => array(
            'rule' => 'notEmpty',
            'message' => 'Please add time duration.'
        ),
        'last' => array(
            'rule' => 'notEmpty',
            'message' => 'Please add time duration.'
        )
    );

}
