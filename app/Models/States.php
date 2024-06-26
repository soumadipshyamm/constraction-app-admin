<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    protected $table = 'states';

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}
