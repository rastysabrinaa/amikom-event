<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    // READ: Menampilkan tabel daftar partner
    public function index(Request $request)
    {
        // Menangkap data input pencarian dari form query parameter '?search='
        $search = $request->query('search');

        // Jika variabel pencarian terisi, filter nama partner menggunakan Eloquent LIKE
        if (!empty($search)) {
            $partners = Partner::where('name', 'LIKE', '%' . $search . '%')->get();
        } else {
            // Jika kosong, tampilkan seluruh partner
            $partners = Partner::all();
        }

        // Kirim data ke view partner index beserta history keyword pencariannya
        return view('admin.partners.index', compact('partners', 'search'));
    }

    // CREATE: Menyimpan partner baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url', // Memastikan input berupa format URL link gambar
        ]);

        Partner::create([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil ditambahkan!');
    }

    // UPDATE: Memperbarui data partner
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo_url' => 'required|url',
        ]);

        $partner = Partner::findOrFail($id);
        $partner->update([
            'name' => $request->name,
            'logo_url' => $request->logo_url,
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil diperbarui!');
    }

    // DELETE: Menghapus partner
    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner berhasil dihapus!');
    }
}