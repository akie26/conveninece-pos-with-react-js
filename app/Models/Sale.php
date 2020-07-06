<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{   

    protected $fillable = [
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
