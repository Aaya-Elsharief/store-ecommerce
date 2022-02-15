<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main_category extends Model
{
    use HasFactory;

    protected $table = "main_categories";
    protected $fillable = [
        'translation_lang',
        'translation_of',
        'name',
        'slug',
        'photo',
        'active',
        'created_at',
        'updated_at'
    ];


    protected $hidden = [
        //
    ];


    public function scopeActive($query){
        return $query -> where('active',1);
    }


}
