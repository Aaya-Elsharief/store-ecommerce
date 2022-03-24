<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
    use HasFactory;

    protected $table = "sub_categories";
    protected $fillable = [
        'translation_lang',
        'translation_of',
        'parent_id',
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

    public function scopeSelection($query){
        return $query -> select('id','parent_id','translation_lang','translation_of','name','slug','photo','active');
    }


    public function getActive(){
        return $this -> active ==1 ? 'مفعّل' : 'غير مفعّل';
    }


    public function getPhotoAttribute($val){
        return  ( $val !== null) ? asset('assets/'.$val) : "";
    }




    /////////  RELATIONS /////////////////
    public function mainCategory(){
        return $this -> belongsTo(Main_category::class,'category_id','id');
    }



}
