<?php

namespace App\Repository;

interface TeacherRepositoryInterface{

    // get all Teachers
    public function getAllTeachers();
    public function Getspecialization();

    // Get Gender
    public function GetGender();
    
    public function StoreTeachers($request);
    public function editTeachers($id);
    
    public function UpdateTeachers($request);
    public function deleteTeacher($request);

    
}

