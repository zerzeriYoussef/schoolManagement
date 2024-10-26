<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repository\StudentGraduatedRepositoryInterface;
use App\Repository\StudentPromotionRepositoryInterface;
use Illuminate\Http\Request;

class GraduatedController extends Controller
{

    protected $Graduated;
    public function __construct(StudentGraduatedRepositoryInterface $Graduated)
    {
        $this->Graduated = $Graduated;
    }

    public function index()
    {
        return $this->Graduated->index();
    }

public function getStudentsBySection($section_id)
{
    
    $list_students = Student::where("section_id", $section_id)->pluck("name", "id");
        return $list_students;
}
public function store(Request $request)
{
    return $this->Graduated->SoftDelete($request);
}
public function create(){
    return $this->Graduated->create();

}

    
}
