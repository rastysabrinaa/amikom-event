<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($id)
    {
        // 1. Ambil data event berdasarkan ID
        $event = Event::with('category')->findOrFail($id);

        // 2. Ambil semua kategori untuk kebutuhan navbar/sidebar
        $categories = Category::all();

        // 3. BENAR: Cukup panggil nama filenya saja tanpa '.blade.php'
        return view('show', compact('event', 'categories'));
    }
}