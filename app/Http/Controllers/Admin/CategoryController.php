<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- Ditambahkan agar bisa menggunakan fungsi Str::slug()

class CategoryController extends Controller
{
    /**
     * READ: Menampilkan halaman utama daftar kategori.
     */
    public function index(Request $request)
    {
        // Menangkap data input pencarian dari form query parameter '?search='
        $search = $request->query('search');

        // Jika ada teks pencarian, filter database menggunakan LIKE operator
        if (!empty($search)) {
            $categories = Category::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            // Jika kosong, tampilkan semua data tanpa filter
            $categories = Category::all();
        }
        
        // Mengirimkan variabel categories dan nilai search kembali ke view
        return view('admin.categories.index', compact('categories', 'search'));
    }

    /**
     * CREATE: Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input nama wajib diisi, berupa string, maksimal 255 karakter, dan unik
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Menyimpan data ke database beserta slug otomatis
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Contoh: "Workshop Digital" menjadi "workshop-digital"
        ]);

        // Redirect kembali ke halaman indeks dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * UPDATE: Memperbarui data kategori yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // Validasi input nama (abaikan keunikan untuk ID kategori ini sendiri saat update)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        // Cari data kategori berdasarkan ID, jika tidak ketemu akan otomatis return 404
        $category = Category::findOrFail($id);
        
        // Memperbarui nama dan memperbarui slug sesuai nama yang baru
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Redirect kembali ke halaman indeks dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data kategori dari database.
     */
    public function destroy($id)
    {
        // Cari data kategori berdasarkan ID
        $category = Category::findOrFail($id);
        
        // Eksekusi penghapusan data
        $category->delete();

        // Redirect kembali ke halaman indeks dengan pesan sukses
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}