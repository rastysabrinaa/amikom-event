<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // 1. Menampilkan Halaman Form Isi Data Pembeli
    public function create(Event $event)
    {
        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    // 2. Memproses Pembelian & Menyimpan ke Database
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Maaf, tiket untuk event ini sudah habis.');
        }

        // Membuat Order ID unik untuk setiap event berbeda
        $orderId = 'TRX-' . rand(10000, 99999);
        $totalPrice = $event->price + 5000; // Harga tiket + biaya admin Rp 5.000

        // Menyimpan data transaksi ke DB secara dinamis berdasarkan $event->id yang sedang di-checkout
        $transaction = Transaction::create([
            'event_id'       => $event->id, // Mengikat transaksi ke event yang benar
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'Pending',
        ]);

        // Mengurangi stok tiket event setelah berhasil checkout
        $event->decrement('stock');

        // Bawa data order_id ke halaman sukses agar strukturnya bisa memuat detail tiket dengan pas!
        return redirect()->route('checkout.success', $transaction->order_id)
                         ->with('success', 'Pembayaran Berhasil!');
    }

    // 3. Menampilkan Halaman E-Ticket Sukses (Biar Layout Tidak Terpotong)
    public function success($order_id)
    {
        // Mencari data transaksi berdasarkan order_id beserta data event-nya
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.success', compact('transaction'));
    }
}