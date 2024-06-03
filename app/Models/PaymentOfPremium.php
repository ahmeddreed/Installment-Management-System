<?php

namespace App\Models;

use App\Models\Shopping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentOfPremium extends Model
{
    use HasFactory;
    protected $fillable = [
        'theRest',
        'pay',
        'shop_id',
        'user_id'
    ];



}
