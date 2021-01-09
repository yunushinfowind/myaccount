<?php

class Pack extends AppModel {

    public $validate = array(
        'pack' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter a pack.'
        )
    );
    public $hasMany = array(
        'Price' => array(
            'dependent' => TRUE
        )
    );

}

?>
