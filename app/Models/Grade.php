<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model 
{
    use HasTranslations;
    protected $guarded = [];
    public $translatable = ['name'];
    protected $table = 'Grades';
    
    public $timestamps = true;
    public function classrooms()
    {
        return $this->hasMany(Classroom::class, 'Grade_id');
    }
    public function Sections()
    {
        return $this->hasMany('App\Models\Section', 'Grade_id');
    }
}