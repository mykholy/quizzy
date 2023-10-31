<?php

return [
    'singular' => 'Question',
    'plural' => 'Questions',
    'type'=>[
        'single_choice'=>'Single Choice',
        'multiple_choice'=>'Multiple Choice',
        'true_false'=>'True/False',
        'short_answer'=>'Short Answer',
        'long_answer'=>'Long Answer',
        'compare'=>'Compare',
    ],
    'fields' => [
        'id' => 'Id',
        'name' => 'Name',
        'type' => 'Type',
        'description' => 'Description',
        'photo' => 'Photo',
        'file' => 'File',
        'subject_id' => 'Subject',
        'unit_id' => 'Unit',
        'semester' => 'Semester',
        'points' => 'Points',
        'time' => 'Time',
        'academic_year_id' => 'Academic year',
        'lesson_id' => 'Lesson',
        'lesson_unit_subject' => 'Lesson >> Unit >> Subject',
        'is_active' => 'Is Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],
];
