<?php

class Teacher extends AppModel {

    public $belongsTo = array(
        'Teacher_information' => array(
            'className' => 'Teacher_information',
            'foreignKey' => 'teacher_information_id'
        ),
        'Subject' => array(
            'className' => 'Subject',
            'foreignKey' => 'subject_id'
        )
    );
}

?>
