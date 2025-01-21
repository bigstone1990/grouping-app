<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grouping extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'user_id',
        'group_id',
        'member_id',
    ];
}
