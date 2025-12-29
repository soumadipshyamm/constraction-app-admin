<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'contact_details';
}
