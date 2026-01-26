<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Pendaftaran Magang') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl rounded-2xl border border-gray-200">
                
                {{-- HEADER FORM --}}
                <div class="bg-blue-900 px-8 py-6">
                    <h3 class="text-white font-bold text-xl">Formulir Peserta Baru</h3>
                    <p class="text-blue-200 text-sm mt-1">Lengkapi data di bawah ini untuk memulai perjalanan magang Anda.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('magang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- SECTION 1: DATA AKADEMIK --}}
                        <div>
                            <h4 class="text-gray-700 font-bold uppercase text-sm border-b pb-2 mb-4 tracking-wider">Data Akademik</h4>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">NIM / NISN</label>
                                    <input type="text" name="nim" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3" required placeholder="Contoh: 12345678">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block font-semibold text-gray-700 mb-2">Asal Universitas / Sekolah</label>
                                        <input type="text" name="universitas" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3" required placeholder="Nama Kampus/Sekolah">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-gray-700 mb-2">Jurusan</label>
                                        <input type="text" name="jurusan" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3" required placeholder="Contoh: Teknik Informatika">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: PERIODE MAGANG --}}
                        <div>
                            <h4 class="text-gray-700 font-bold uppercase text-sm border-b pb-2 mb-4 tracking-wider">Periode Pelaksanaan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3" required>
                                </div>
                                <div>
                                    <label class="block font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-3" required>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 3: DOKUMEN --}}
                        <div>
                            <h4 class="text-gray-700 font-bold uppercase text-sm border-b pb-2 mb-4 tracking-wider">Dokumen Pendukung</h4>
                            <div class="bg-blue-50 p-6 rounded-xl border-2 border-dashed border-blue-200 text-center hover:bg-blue-100 transition duration-300">
                                <svg class="w-12 h-12 mx-auto text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <label class="block font-bold text-gray-700 mb-2 cursor-pointer">
                                    <span class="text-blue-600 underline">Upload Surat Balasan</span> / Pengantar (PDF)
                                </label>
                                <input type="file" name="surat_balasan" accept=".pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition cursor-pointer" required>
                                <p class="text-xs text-gray-500 mt-3">*Format PDF, Maksimal ukuran file 2MB.</p>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100">
                            <button type="submit" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 text-lg">
                                🚀 Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>