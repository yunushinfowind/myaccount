<?php

class Subject extends AppModel {

    public $validate = array(
        'subject' => array(
            'rule' => 'notEmpty',
            'required' => FALSE,
            'message' => 'Please add Subject.'
        ),
    );
    public $hasMany = array(
        'Price' => array(
            'className' => 'Price',
            'foreignKey' => 'subject'
        ),
        'Teacher' => array(
            'className' => 'Teacher',
            'foreignKey' => 'subject_id'
        ),
        'Assigned_teacher' => array(
            'className' => 'Assigned_teacher',
            'foreignKey' => 'subject_id'
        ),
    );

}

?>
