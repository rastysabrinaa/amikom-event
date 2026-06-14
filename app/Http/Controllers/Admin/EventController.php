<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->latest()->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.event.create', compact('categories'));
    }
}