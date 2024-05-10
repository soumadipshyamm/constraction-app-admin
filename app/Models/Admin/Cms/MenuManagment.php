<?php

namespace App\Models\Admin\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class MenuManagment extends Model
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
    public function pageManagment()
    {
        return $this->belongsTo(PageManagment::class, 'site_page', 'id');
    }

    public function scopeInternal($query)
    {
        return $query->where('type', 'internal');
    }
    public function scopeExInternal($query)
    {
        return $query->where('type', 'external');
    }
}
