<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory, Notifiable;


    protected $table = "vendors";
    protected $fillable = [
        'name',
        'logo',
        'address',
        'password',
        'mobile',
        'email',
        'active',
        'category_id',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'category_id',
        'password',
    ];

    public function scopeSelection($query){
        return $query -> select('id','category_id','name','logo','mobile','active','address','email');
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

    public function setPasswordAttribute($password){
        if(!empty($password)){
            $this -> attributes['password'] = bcrypt($password);
        }
    }

    /////////  RELATIONS /////////////////
    public function category(){
        return $this -> belongsTo('App\Models\Main_category','category_id','id');
    }

}

