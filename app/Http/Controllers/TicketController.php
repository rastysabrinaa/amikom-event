<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * 1. Menampilkan Form Input Data Pembeli (Checkout)
     */
    public function create($id)
    {
        // Mencari data event berdasarkan ID atau slug yang dikirim rute
        $event = Event::findOrFail($id);

        // Validasi ketersediaan kuota tiket
        if ($event->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, kuota tiket untuk event ini sudah habis!');
        }

        // Berdasarkan direktori views kamu: memanggil file resources/views/checkout.blade.php
        return view('checkout', compact('event'));
    }

    /**
     * 2. Menyimpan Data Transaksi Pembelian ke Database
     */
    public function store(Request $request, $id)
    {
        // Validasi input data dari form checkout
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $event = Event::findOrFail($id);

        if ($event->stock <= 0) {
            return redirect()->back()->with('error', 'Transaksi dibatalkan karena tiket habis!');
        }

        // Membuat kode unik acak untuk e-ticket pembeli
        $orderId = 'AMIKOM-' . strtoupper(Str::random(8));

        // Menyimpan record baru ke tabel transactions
        $transaction = Transaction::create([
            'order_id'     => $orderId,
            'event_id'     => $event->id,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'total_price'  => $event->price,
            'status'       => 'success', // Otomatis diset lunas demi kemudahan simulasi
        ]);

        // Mengurangi jumlah stok tiket pada event terkait
        $event->decrement('stock');

        // Mengarahkan pembeli ke rute invoice sukses dengan membawa parameter order_id
        return redirect()->route('checkout.success', $transaction->order_id)
                         ->with('success', 'Pembelian tiket berhasil diproses!');
    }

    /**
     * 3. Menampilkan Nota / Halaman Struk E-Ticket Sukses
     */
    public function success($order_id)
    {
        // Mengambil data transaksi beserta relasi data event-nya
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        // Berdasarkan direktori views kamu: memanggil file resources/views/ticket.blade.php
        return view('ticket', compact('transaction'));
    }

    /**
     * Fungsi bawaan awal untuk melihat daftar tiket pembeli
     */
    public function show()
    {
        return view('ticket');
    }
}