@extends('layouts.app')

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                #1 Event Platform
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            <div class="flex gap-4">
                <a href="#events"
                    class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="#"
                    class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <img src="{{ asset('assets/concert.png') }}" alt="Concert"
                class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/') }}#events" 
                   class="px-4 py-2.5 rounded-xl text-sm font-bold transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>
                
                @foreach($categories as $cat)
                    <a href="{{ url('/?category=' . $cat->slug) }}#events" 
                       class="px-4 py-2.5 rounded-xl text-sm font-bold transition {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-indigo-50 text-indigo-600 hover:bg-indigo-100' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="relative overflow-hidden aspect-[4/3]">
                        <img src="https://placehold.co/600x400" alt="{{ $event->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow-sm">
                            {{ $event->category->name }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition line-clamp-2 min-h-[3.5rem]">
                            {{ $event->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-50">
                            <span class="text-xl font-black text-indigo-600">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('admin.login') == false ? route('events.show', $event->id) : route('events.show', $event->id) }}"
                                class="px-5 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-slate-400 font-medium bg-slate-50 rounded-3xl border border-dashed">
                    Belum ada event tersedia untuk kategori ini.
                </div>
            @endforelse
        </div>
    </section>

    <section class="py-20 bg-slate-50/50 border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14">
                <span class="text-xs font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-4 py-1.5 rounded-full">
                    Sponsorship
                </span>
                <h2 class="text-3xl font-extrabold text-slate-800 mt-3">Official Partners & Sponsors</h2>
                <p class="text-slate-500 mt-2 font-medium">Didukung oleh instansi dan perusahaan resmi terpercaya</p>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-10 md:gap-16">
                @forelse($partners as $partner)
                    <div class="flex flex-col items-center group" title="{{ $partner->name }}">
                        <div class="w-32 h-32 bg-white rounded-2xl p-4 border border-slate-100 shadow-sm flex items-center justify-center hover:shadow-xl hover:border-indigo-500/20 transition-all duration-300 transform hover:-translate-y-1">
                            <img src="{{ $partner->logo_url }}" alt="Logo {{ $partner->name }}" 
                                class="max-w-full max-h-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
                        </div>
                        <span class="mt-3 text-xs font-bold text-slate-400 group-hover:text-slate-700 transition duration-300">
                            {{ $partner->name }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-400 font-medium">
                        Membuka peluang kemitraan dan sponsorship event.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection