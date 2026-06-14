<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Partner;
use App\Models\Event; // <-- 1. Tambahkan import model Event di sini
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

        // 3. Tambahkan ini: Ambil semua data event untuk section event
        $events = Event::all(); // atau gunakan Event::latest()->get() jika ingin event terbaru di atas

        // 4. Render ke view welcome.blade.php sambil membawa semua data (tambahkan 'events')
        return view('welcome', compact('categories', 'partners', 'events'));
    }
}