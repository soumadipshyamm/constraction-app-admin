<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class SubscriptionLogs extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts=[
        'payment_data'=>'json'
    ];
}
