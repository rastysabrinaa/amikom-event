<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Menampilkan halaman depan publik (Homepage)
     */
    public function index()
    {
        // 1. Ambil semua data kategori untuk section kategori
        $categories = Category::all();

        // 2. Ambil semua data partner untuk section sponsor/partner
        $partners = Partner::all();

        // 3. Render ke view welcome.blade.php sambil membawa data
        return view('welcome', compact('categories', 'partners'));
    }
}