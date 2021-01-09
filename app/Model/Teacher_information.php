<?php

class Teacher_information extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'classname' => 'User',
            'foreignKey' => 'user_id'
        ),
    );
    public $hasMany = array(
        'Teacher' => array(
            'className' => 'Teacher',
            'foreignKey' => 'teacher_information_id',
            'dependent' => TRUE
        ),
        'Assigned_teacher' => array(
            'className' => 'Assigned_teacher',
            'foreignKey' => 'teacher_information_id',
            'dependent' => TRUE
        ),
    );

}

?>
