<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // 1. Mendaftarkan kolom agar bisa diisi oleh Controller
    protected $fillable = [
        'event_id',
        'order_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_price',
        'status',
    ];

    // 2. Membuat relasi balik ke Model Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}