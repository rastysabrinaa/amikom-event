@extends('layouts.admin')
@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Order ID</th>
                    <th class="px-8 py-4">Detail Pembeli</th>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tgl Transaksi</th>
                    <th class="px-8 py-4">Status</th>
                    <th class="px-8 py-4 text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $trx)
                {{-- Menggunakan strtolower untuk menghindari error case-sensitivity --}}
                @php $statusLower = strtolower($trx->status); @endphp
                
                <tr class="hover:bg-slate-50/50 transition {{ $statusLower == 'pending' ? 'text-slate-400' : '' }}">
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold px-3 py-1 rounded-lg text-sm {{ $statusLower == 'pending' ? 'bg-slate-100 text-slate-500' : 'text-indigo-600 bg-indigo-50' }}">
                            {{ $trx->order_id }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-500">{{ $trx->customer_email }}<br>{{ $trx->customer_phone }}</p>
                    </td>
                    <td class="px-8 py-6">
                        {{-- Memastikan jika title kosong, mencoba mengambil name --}}
                        <p class="font-medium text-slate-700">{{ $trx->event->title ?? $trx->event->name ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500">
                        {{ $trx->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-8 py-6">
                        @if($statusLower === 'settlement' || $statusLower === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">Success</span>
                        @elseif($statusLower === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right font-black {{ $statusLower == 'pending' ? 'text-slate-400' : 'text-slate-900' }}">
                        Rp {{ number_format($transaction->total_price ?? $trx->total_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    {{-- Diubah menjadi colspan="7" karena total ada 6 baris data + 1 text-right alignment --}}
                    <td colspan="7" class="px-8 py-10 text-center text-slate-400 font-medium">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Navigasi Halaman (Hanya muncul jika data lebih dari limit paginate) --}}
    @if($transactions->hasPages())
        <div class="px-8 py-6 bg-slate-50/50 border-t">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection