<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Log Book Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 font-bold">{{ session('success') }}</div>
            @endif

            {{-- HEADER PROFIL --}}
            <div class="bg-blue-900 text-white rounded-lg shadow-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-blue-200 text-sm uppercase">Nama Mahasiswa</h3>
                        <p class="text-xl font-bold">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <h3 class="text-blue-200 text-sm uppercase">Penempatan Unit</h3>
                        {{-- Ambil dari tabel magangs, pakai tanda ?? jika data belum ada --}}
                        <p class="text-lg">{{ $profil->penempatan ?? 'Belum ditentukan' }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- FORM INPUT --}}
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6 sticky top-20">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">📝 Input Kegiatan</h3>
                        
                        {{-- enctype="multipart/form-data" WAJIB ADA UNTUK UPLOAD FILE --}}
                        <form action="{{ route('logbook.store') }}" method="POST" id="logbookForm" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Koordinator</label>
                                <input type="text" name="nama_koordinator" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <input type="text" name="lokasi" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kegiatan</label>
                                <textarea name="kegiatan" rows="3" required class="mt-1 block w-full rounded border-gray-300 shadow-sm"></textarea>
                            </div>

                            {{-- INPUT FOTO --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Bukti Foto (Opsional)</label>
                                <input type="file" name="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                            </div>

                            {{-- CANVAS TANDA TANGAN --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Paraf Koordinator (Wajib)</label>
                                <div class="border-2 border-dashed border-gray-400 rounded bg-gray-50 flex justify-center">
                                    <canvas id="signature-pad" class="w-full h-32 cursor-crosshair"></canvas>
                                </div>
                                <button type="button" id="clear" class="text-xs text-red-600 underline mt-1">Hapus Tanda Tangan</button>
                                <input type="hidden" name="ttd_koordinator" id="ttd_input">
                            </div>

                            <button type="submit" class="w-full bg-blue-900 text-white font-bold py-2 rounded hover:bg-blue-800">Simpan Logbook</button>
                        </form>
                    </div>
                </div>

                {{-- TABEL RIWAYAT --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">📚 Riwayat Jurnal</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bukti & Paraf</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($logs as $log)
                                        <tr>
                                            <td class="px-4 py-3 text-sm align-top">{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 text-sm align-top">
                                                <p class="font-bold">{{ $log->kegiatan }}</p>
                                                <p class="text-xs text-gray-500">📍 {{ $log->lokasi }} | 👤 {{ $log->nama_koordinator }}</p>
                                            </td>
                                            <td class="px-4 py-3 text-center align-top space-y-2">
                                                {{-- FOTO --}}
                                                @if($log->foto_kegiatan)
                                                    <a href="{{ asset('storage/'.$log->foto_kegiatan) }}" target="_blank" class="text-blue-600 text-xs underline">Lihat Foto</a>
                                                @endif
                                                
                                                {{-- TTD --}}
                                                @if($log->ttd_koordinator)
                                                    <img src="{{ $log->ttd_koordinator }}" class="h-8 mx-auto border-b border-gray-300" alt="Paraf">
                                                @endif

                                                <form action="{{ route('logbook.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-500 text-xs hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT TANDA TANGAN --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);
            var clearButton = document.getElementById('clear');
            var form = document.getElementById('logbookForm');
            var ttdInput = document.getElementById('ttd_input');

            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            clearButton.addEventListener('click', () => signaturePad.clear());

            form.addEventListener('submit', function (e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert("Paraf Koordinator wajib diisi!");
                } else {
                    ttdInput.value = signaturePad.toDataURL();
                }
            });
        });
    </script>
</x-app-layout>