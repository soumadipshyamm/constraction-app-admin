<?php

namespace App\Models;

use App\Models\Admin\CompanyManagment;
use App\Models\Company\CompanyUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts=[
        'payment_data'=>'array'
    ];

    public function users()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }
    public function companys()
    {
        return $this->belongsTo(CompanyManagment::class, 'company_id', 'id');
    }
}
