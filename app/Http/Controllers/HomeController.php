<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Partner; // Tambahkan ini agar Model Partner bisa digunakan
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama publik (Welcome/Homepage)
     */
    public function index(Request $request)
    {
        // 1. Ambil data kategori untuk filter tab dinamis
        $categories = Category::all();

        // 2. Ambil data partner untuk bagian bawah (Official Partners & Sponsors)
        $partners = Partner::all(); // Ini yang sebelumnya kurang, sehingga menyebabkan error

        // 3. Logika pencarian/filter event berdasarkan kategori jika ada request query
        $query = Event::with('category');

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $events = $query->latest()->get();

        // 4. Kirimkan semua variabel ($categories, $events, $partners) ke view welcome
        return view('welcome', compact('categories', 'events', 'partners'));
    }
}