<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddPremium extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'inte_id',
        'cate_id',
        'price',
    ];
}
