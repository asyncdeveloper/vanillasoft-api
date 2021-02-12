<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomEmail extends Model
{
    use HasFactory;

    protected $casts = [ 'attachments' => 'array' ];

    protected $guarded = [ 'id' ];

}
