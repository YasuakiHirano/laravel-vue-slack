<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mention extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['message_id', 'user_id', 'create_user_id'];
}
