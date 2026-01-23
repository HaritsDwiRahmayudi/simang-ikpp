<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Laporan Mingguan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- INFO MINGGU INI --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-900">
                        Laporan Minggu ke-{{ $laporan->minggu_ke }}
                    </h3>
                    <p class="text-gray-600 text-sm">
                        Periode: {{ \Carbon\Carbon::parse($laporan->tgl_awal_minggu)->translatedFormat('d F Y') }} 
                        s/d 
                        {{ \Carbon\Carbon::parse($laporan->tgl_akhir_minggu)->translatedFormat('d F Y') }}
                    </p>
                </div>

                {{-- STATUS SAAT INI --}}
                <div class="mb-6">
                    <span class="block text-gray-700 text-sm font-bold mb-2">Status Validasi Admin:</span>
                    @if($laporan->status == 'pending')
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                            <p class="font-bold">⏳ Menunggu Pemeriksaan</p>
                            <p class="text-sm">Admin belum memvalidasi laporan Anda.</p>
                        </div>
                    @elseif($laporan->status == 'disetujui')
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <p class="font-bold">✅ DISETUJUI</p>
                            <p class="text-sm">Laporan Anda diterima. Absensi minggu ini otomatis terisi HADIR.</p>
                        </div>
                    @elseif($laporan->status == 'ditolak')
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                            <p class="font-bold">❌ DITOLAK</p>
                            <p class="text-sm">Laporan ditolak. Silakan upload ulang file revisi segera.</p>
                        </div>
                    @endif
                </div>

                {{-- FORM UPLOAD --}}
                @if($laporan->status != 'disetujui') 
                    {{-- Hanya tampilkan form jika BELUM disetujui --}}
                    
                    <form action="{{ route('laporan.upload') }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-6 rounded-lg border border-dashed border-gray-400">
                        @csrf
                        <input type="hidden" name="laporan_id" value="{{ $laporan->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file_pdf">
                                Upload File Laporan (PDF)
                            </label>
                            <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" required
                                class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file 2MB.</p>
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            📤 Upload Laporan
                        </button>
                    </form>

                @else
                    {{-- Jika sudah disetujui, tampilkan tombol download file sendiri --}}
                    <div class="bg-gray-50 p-4 rounded border">
                        <p class="text-gray-600 text-sm mb-2">File yang Anda upload:</p>
                        <a href="{{ asset('storage/' . $laporan->file_pdf) }}" target="_blank" class="text-blue-600 font-bold hover:underline flex items-center">
                            📄 Lihat File Saya
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>