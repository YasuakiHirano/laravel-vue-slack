<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInformation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'image_number', 'send_email', 'status'];
}
