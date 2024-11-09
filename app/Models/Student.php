<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes; //momkn tamli machakl baad adhi lel delete ama archive fel graduatedstudent
use Illuminate\Foundation\Auth\User as Authenticatable; 
class Student extends Authenticatable
{
    use SoftDeletes;

    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

    // علاقة بين الطلاب والانواع لجلب اسم النوع في جدول الطلاب

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender', 'gender_id');
    }

    // علاقة بين الطلاب والمراحل الدراسية لجلب اسم المرحلة في جدول الطلاب

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'Grade_id');
    }


    // علاقة بين الطلاب الصفوف الدراسية لجلب اسم الصف في جدول الطلاب

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom', 'Classroom_id');
    }

    // علاقة بين الطلاب الاقسام الدراسية لجلب اسم القسم  في جدول الطلاب

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
       // علاقة بين الطلاب والصور لجلب اسم الصور  في جدول الطلاب
       public function images()
       {
        return $this->morphMany(Image::class, 'imageable');
       }
       
    public function myparent()
    {
        return $this->belongsTo('App\Models\My_Parent', 'parent_id');
    }
   // علاقة بين جدول سدادت الطلاب وجدول الطلاب لجلب اجمالي المدفوعات والمتبقي
   public function student_account()
   {
       return $this->hasMany('App\Models\StudentAccount', 'student_id');

   }
   public function attendance()
   {
       return $this->hasMany('App\Models\Attendance', 'student_id');
   }
}
