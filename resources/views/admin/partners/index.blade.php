@extends('layouts.admin')

@section('content')
<main class="flex-1 p-10 overflow-y-auto">
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl font-semibold flex justify-between items-center animate-fade-in">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">&times;</button>
        </div>
    @endif

    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black">Partner & Sponsor</h1>
            <p class="text-slate-500 font-medium">Kelola daftar partner resmi event Anda.</p>
        </div>
        <button onclick="openModal('modal-tambah')"
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition cursor-pointer">
            + Tambah Partner
        </button>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">
            <input type="text" id="searchPartner" placeholder="Cari partner..."
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4 w-24">Logo</th>
                        <th class="px-8 py-4">Nama Partner</th>
                        <th class="px-8 py-4">Waktu Diperbarui</th>
                        <th class="px-8 py-4 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t" id="partnerTableBody">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-8 py-6">
                                <img src="{{ $partner->logo_url }}" alt="Logo {{ $partner->name }}" 
                                    class="w-12 h-12 rounded-xl object-contain bg-slate-50 border border-slate-100">
                            </td>
                            <td class="px-8 py-6">
                                <p class="font-black text-slate-800 partner-name">{{ $partner->name }}</p>
                            </td>
                            <td class="px-8 py-6 text-slate-500 font-medium text-sm">
                                {{ $partner->updated_at ? $partner->updated_at->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-2">
                                    <button onclick="openEditModal('{{ $partner->id }}', '{{ $partner->name }}', '{{ $partner->logo_url }}')"
                                        class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner \'{{ $partner->name }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-slate-400 font-medium">
                                Belum ada data partner.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="modal-tambah" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] w-full max-w-md p-8 border border-slate-100 shadow-2xl scale-95 transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-800">Tambah Partner Baru</h3>
            <button onclick="closeModal('modal-tambah')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="{{ route('admin.partners.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-slate-500 font-bold text-sm mb-2">Nama Partner</label>
                <input type="text" name="name" placeholder="Contoh: PT. Amikom Media" required
                    class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium">
            </div>
            <div class="mb-6">
                <label class="block text-slate-500 font-bold text-sm mb-2">URL Logo Partner</label>
                <input type="url" name="logo_url" placeholder="Contoh: https://link-gambar.com/logo.png" required
                    class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-tambah')"
                    class="px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modal-edit" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] w-full max-w-md p-8 border border-slate-100 shadow-2xl scale-95 transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-slate-800">Edit Data Partner</h3>
            <button onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form id="form-edit-partner" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-slate-500 font-bold text-sm mb-2">Nama Partner</label>
                <input type="text" id="edit-partner-name" name="name" required
                    class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium">
            </div>
            <div class="mb-6">
                <label class="block text-slate-500 font-bold text-sm mb-2">URL Logo Partner</label>
                <input type="url" id="edit-partner-logo" name="logo_url" required
                    class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition font-medium">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('modal-edit')"
                    class="px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-md shadow-indigo-100 transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => { modal.firstElementChild.classList.remove('scale-95'); }, 10);
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.firstElementChild.classList.add('scale-95');
        setTimeout(() => { modal.classList.add('hidden'); }, 200);
    }

    function openEditModal(id, currentName, currentLogo) {
        const form = document.getElementById('form-edit-partner');
        const inputName = document.getElementById('edit-partner-name');
        const inputLogo = document.getElementById('edit-partner-logo');
        
        form.action = `/admin/partners/${id}`;
        inputName.value = currentName;
        inputLogo.value = currentLogo;
        
        openModal('modal-edit');
    }

    document.getElementById('searchPartner').addEventListener('input', function(e) {
        const searchWord = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#partnerTableBody tr');
        
        rows.forEach(row => {
            const nameEl = row.querySelector('.partner-name');
            if(nameEl) {
                const text = nameEl.textContent.toLowerCase();
                row.style.display = text.includes(searchWord) ? '' : 'none';
            }
        });
    });
</script>
@endsection