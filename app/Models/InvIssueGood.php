<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class InvIssueGood extends Model
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

    public function invIssue()
    {
        return $this->belongsTo(InvIssue::class, 'inv_issues_id', 'id');
    }
    public function invIssueList()
    {
        return $this->belongsTo(InvIssueList::class, 'inv_issue_lists_id', 'id');
    }

    public function invIssueDetails()
    {
        return $this->hasMany(InvIssuesDetails::class, 'inv_issue_goods_id', 'id');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
