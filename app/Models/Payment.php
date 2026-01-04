<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'payments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    protected $guarded = [];

    // Relasi: Payment dimiliki oleh satu Booking
    // public function booking()
    // {
    //     return $this->belongsTo(\App\Models\Booking::class, 'id', 'payment_id');
    // }

    public function order()
    {
        return $this->belongsTo(\App\Models\Orders::class, 'id', 'payment_id');
    }
}
