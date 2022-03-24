<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;


    protected $table = "brands";
    protected $fillable = [
        'name',
        'logo',
        'active',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];



    public function scopeSelection($query){
        return $query -> select('id','name','logo','active');
    }

    public function scopeActive($query){
        return $query -> where('active',1);
    }


    public function getActive(){
        return $this -> active ==1 ? 'مفعّل' : 'غير مفعّل';
    }


    public function getLogoAttribute($val){
        return  ( $val !== null) ? asset('assets/'.$val) : "";
    }


}

