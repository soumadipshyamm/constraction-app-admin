<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUserPermission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function  menu(){
        return $this->hasMany(AdminMenu::class,'id','menu_id');
    }
    public function  user(){
        return $this->belongsToMany(User::class,'user_id');
    }
}
