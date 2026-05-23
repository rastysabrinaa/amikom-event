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
            <h1 class="text-3xl font-black">Kategori Event</h1>
            <p class="text-slate-500 font-medium">Kelola daftar kategori untuk event Anda.</p>
        </div>
        <button onclick="openModal('modal-tambah')"
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition cursor-pointer">
            + Tambah Kategori
        </button>
    </header>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-8 py-6 bg-slate-50/50 border-b flex gap-4">
            <input type="text" id="searchCategory" placeholder="Cari kategori..."
                class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-4 w-16">No</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t" id="categoryTableBody">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-8 py-6">
                                <p class="font-black text-slate-800 category-name">{{ $category->name }}</p>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex gap-2">
                                    <button onclick="openEditModal('{{ $category->id }}', '{{ $category->name }}')"
                                        class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori \'{{ $category->name }}\'?')">
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
                            <td colspan="3" class="px-8 py-10 text-center text-slate-400 font-medium">
                                Belum ada data kategori.
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
            <h3 class="text-xl font-black text-slate-800">Tambah Kategori Baru</h3>
            <button onclick="closeModal('modal-tambah')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-slate-500 font-bold text-sm mb-2">Nama Kategori</label>
                <input type="text" name="name" placeholder="Contoh: Webinar, Concert, dll." required
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
            <h3 class="text-xl font-black text-slate-800">Edit Nama Kategori</h3>
            <button onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-slate-600 text-2xl font-bold">&times;</button>
        </div>
        <form id="form-edit-kategori" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-slate-500 font-bold text-sm mb-2">Nama Kategori</label>
                <input type="text" id="edit-category-name" name="name" required
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
    // Fungsi umum membuka modal
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.firstElementChild.classList.remove('scale-95');
        }, 10);
    }

    // Fungsi umum menutup modal
    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.firstElementChild.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    // Fungsi khusus untuk membuka modal edit dengan data dinamis
    function openEditModal(id, currentName) {
        const form = document.getElementById('form-edit-kategori');
        const inputName = document.getElementById('edit-category-name');
        
        // Atur action form sesuai ID kategori yang dipilih
        form.action = `/admin/categories/${id}`;
        // Isi input dengan nama kategori saat ini
        inputName.value = currentName;
        
        openModal('modal-edit');
    }

    // Fitur Live Search Tambahan (Biar makin keren dan fungsional)
    document.getElementById('searchCategory').addEventListener('input', function(e) {
        const searchWord = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#categoryTableBody tr');
        
        rows.forEach(row => {
            const nameEl = row.querySelector('.category-name');
            if(nameEl) {
                const text = nameEl.textContent.toLowerCase();
                if(text.includes(searchWord)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });
</script>
@endsection