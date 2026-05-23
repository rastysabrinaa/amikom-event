<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    // Menentukan kolom mimum database sesuai ketentuan soal ujian
    protected $fillable = ['name', 'logo_url']; 
}