@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-8 flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/2 aspect-[4/5] bg-slate-100 rounded-2xl overflow-hidden flex items-center justify-center text-slate-400">
            <span class="text-sm font-medium">Gambar/Poster Event</span>
        </div>

        <div class="flex-1 flex flex-col justify-between space-y-6">
            <div>
                <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold uppercase mb-3">
                    {{ $event->category->name ?? 'Kategori' }}
                </span>
                <h1 class="text-3xl font-black text-slate-800 leading-tight mb-2">{{ $event->title }}</h1>
                <p class="text-sm text-slate-500 mb-4">
                    📅 {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y, H:i') }} WIB
                </p>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Jangan lewatkan keseruan event resmi ini. Amankan kuota tempat duduk Anda sebelum kehabisan tiket! Stok sangat terbatas.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase">Harga Tiket</p>
                        <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-slate-400 font-bold uppercase">Sisa Kuota</p>
                        <p class="text-sm font-bold text-slate-700">{{ $event->stock }} Tiket</p>
                    </div>
                </div>

                <a href="{{ route('checkout.create', $event->id) }}" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold text-center block shadow-lg shadow-indigo-100 transition transform active:scale-95">
                    Beli Tiket Sekarang
                </a>
            </div>
        </div>
    </div>
</main>
@endsection