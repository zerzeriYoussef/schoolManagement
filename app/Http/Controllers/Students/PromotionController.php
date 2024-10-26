<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Repository\StudentPromotionRepositoryInterface;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    protected $Promotion;
    public function __construct(StudentPromotionRepositoryInterface $Promotion)
    {
        $this->Promotion = $Promotion;
    }

    public function index()
    {
        return $this->Promotion->index();
    }

public function getStudentsBySection($section_id)
{
    
    $list_students = Student::where("section_id", $section_id)->pluck("name", "id");
        return $list_students;
}
public function store(Request $request)
{
    return $this->Promotion->store($request);
}
    
}
