<?php

namespace App\Models\API;

use App\Models\Company\CompanyUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Hinderance extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::generate(4);
        });
    }
    public function dpr()
    {
        return $this->belongsTo(Dpr::class, 'dpr_id');
    }
    public function companyUsers()
    {
        return $this->belongsTo(CompanyUser::class, 'company_users_id');
    }
}
