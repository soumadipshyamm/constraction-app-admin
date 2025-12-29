<?php

namespace App\Models;

use App\Models\Company\Activities;
use App\Models\Company\Assets;
use App\Models\Company\Materials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class InvIssuesDetails extends Model
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

    public function InvIssueGood()
    {
        return $this->belongsTo(InvIssueGood::class, 'inv_issue_goods_id', 'id');
    }
    public function materials()
    {
        return $this->belongsTo(Materials::class, 'materials_id', 'id');
    }
    public function assets()
    {
        return $this->belongsTo(Assets::class, 'assets_id', 'id');
    }
    public function activites()
    {
        return $this->belongsTo(Activities::class, 'activities_id', 'id');
    }
}
