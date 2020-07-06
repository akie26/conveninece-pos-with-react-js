<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'user_id',
        'sale_id',
    ];

    protected $help = [
        'user_id' => 'array',
    ];

    

}
