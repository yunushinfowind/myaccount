<?php

class Price extends AppModel {

    public $validate = array(
        'subject' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a Subject.'
        ),
        'duration' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select duration.'
        ),
        'pack' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select a Pack.'
        ),
        'price' => array(
            'rule' => 'notEmpty',
            'message' => 'Please enter Price.'
        ),
        'pricing_type' => array(
            'rule' => 'notEmpty',
            'message' => 'Please select Pricing Type.'
        )
    );
    public $belongsTo = array(
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject'
        ),
        'Pack'
       
    );
    
    
//    public $hasMany = array(
//         'Pack'
//    );

}

?>
