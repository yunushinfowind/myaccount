<?php

class Duration extends AppModel {

    public $validate = array(
        'duration' => array(
            'rule' => 'notEmpty',
            'required' => false,
            'message' => 'Please enter Duration.'
        )
    );

}

?>
