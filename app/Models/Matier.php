<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matier extends Model
{
    use HasTranslations;
    protected $guarded = [];
    public $translatable = ['name'];
    
    public $timestamps = true;
    public function sectionse()
    {
        return $this->belongsToMany('App\Models\Section','matier_section');
    }


}
