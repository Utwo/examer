<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Max projects upload
    |--------------------------------------------------------------------------
    |
    | Cate proiecte are voie un singur utilizator sa incarce?
    |
    */

    'max_project_upload' => env('MAX_PROJECT_UPLOAD', 3),


    /*
    |--------------------------------------------------------------------------
    | Max projects upload
    |--------------------------------------------------------------------------
    |
    | Cate note are voie sa dea un utilizator?
    |
    */
    'max_grade_add' => env('MAX_GRADE_ADD', 3),

    /*
    |--------------------------------------------------------------------------
    | Grade for project
    |--------------------------------------------------------------------------
    |
    | Cate note poate sa aiba un singur proiect?
    |
    */
    'grade_for_project' => env('GRADE_FOR_PROJECT', 3),

];
