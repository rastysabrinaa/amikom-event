<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment).
     * Kolom 'slug' wajib ditambahkan di sini karena database Anda membutuhkan data slug 
     * setiap kali membuat atau memperbarui kategori baru.
     */
    protected $fillable = ['name', 'slug']; 
}