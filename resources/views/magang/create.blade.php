<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Pendaftaran Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Lengkapi Data Diri & Akademik</h3>
                    
                   <form method="POST" action="{{ route('magang.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="space-y-6">
        
        {{-- NAMA LENGKAP (Read Only) --}}
        <div>
            <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input type="text" value="{{ Auth::user()->name }}" disabled 
                class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm">
            <p class="text-xs text-gray-500 mt-1">*Sesuai nama akun.</p>
        </div>

        {{-- GRID 2 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- NIM --}}
            <div>
                <label for="nim" class="block font-medium text-sm text-gray-700">NIM / NPM</label>
                <input type="text" name="nim" id="nim" required placeholder="Contoh: 19010023"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- JURUSAN --}}
            <div>
                <label for="jurusan" class="block font-medium text-sm text-gray-700">Jurusan / Prodi</label>
                <input type="text" name="jurusan" id="jurusan" required placeholder="Contoh: Teknik Informatika"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- UNIVERSITAS --}}
        <div>
            <label for="universitas" class="block font-medium text-sm text-gray-700">Asal Universitas / Sekolah</label>
            <input type="text" name="universitas" id="universitas" required placeholder="Contoh: Universitas Riau"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- TANGGAL MAGANG --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tanggal_mulai" class="block font-medium text-sm text-gray-700">Rencana Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="tanggal_selesai" class="block font-medium text-sm text-gray-700">Rencana Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- UPLOAD SURAT BALASAN (BARU) --}}
        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <label for="surat_balasan" class="block font-bold text-sm text-gray-800 mb-2">
                Upload Surat Balasan/Penerimaan dari PT Indah Kiat
            </label>
            <input type="file" name="surat_balasan" id="surat_balasan" accept=".pdf" required
                class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-600 file:text-white
                file:hover:bg-blue-700">
            <p class="text-xs text-gray-600 mt-2">
                *Wajib format <strong>PDF</strong>. Maksimal ukuran 2MB.<br>
                *Ini adalah bukti sah bahwa Anda telah diterima magang.
            </p>
            @error('surat_balasan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- TOMBOL KIRIM --}}
        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                Kirim Pendaftaran
            </button>
        </div>

    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>