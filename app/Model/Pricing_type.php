<?php

class Pricing_type extends AppModel {
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter a Name.'
        )
    );
    
}
?>