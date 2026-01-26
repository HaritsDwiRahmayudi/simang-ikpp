<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-blue-900">
                {{ __('Logbook Kegiatan') }}
            </h2>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-logbook')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md flex items-center transition transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Isi Logbook Baru
            </button>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- TABEL LOGBOOK --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-48">Lokasi & Koordinator</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Uraian Kegiatan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Dokumentasi</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Paraf</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                                <tr class="hover:bg-blue-50 transition duration-200">
                                    <td class="px-6 py-4 align-top text-sm font-semibold text-gray-700">
                                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-md text-center">
                                            {{ \Carbon\Carbon::parse($log->tanggal)->format('d M') }}
                                            <div class="text-xs font-normal mt-1">{{ \Carbon\Carbon::parse($log->tanggal)->format('Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-sm font-bold text-gray-800">{{ $log->lokasi }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            {{ $log->nama_koordinator }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top text-sm text-gray-600 whitespace-pre-line leading-relaxed">
                                        {{ $log->kegiatan }}
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        @if($log->foto_kegiatan)
                                            <a href="{{ asset('storage/' . $log->foto_kegiatan) }}" target="_blank" class="inline-block relative group">
                                                <img src="{{ asset('storage/' . $log->foto_kegiatan) }}" class="h-12 w-12 rounded-lg object-cover border border-gray-300 shadow-sm transition transform group-hover:scale-150 group-hover:z-50 group-hover:border-white group-hover:shadow-2xl">
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        @if($log->ttd_koordinator)
                                            <img src="{{ asset('storage/' . $log->ttd_koordinator) }}" class="h-12 w-auto mx-auto border border-gray-200 rounded p-1 bg-white">
                                        @else
                                            <span class="text-gray-300 text-xs italic">Belum TTD</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-gray-500 italic">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <p>Belum ada catatan kegiatan. Yuk, isi sekarang!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-logbook" focusable>
        <div class="p-8">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h2 class="text-2xl font-bold text-blue-900">Tambah Kegiatan</h2>
                <button x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            
            <form id="logbookForm" action="{{ route('logbook.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Lokasi Unit</label>
                        <input type="text" name="lokasi" placeholder="Contoh: Gedung IT" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Koordinator / Pembimbing</label>
                    <input type="text" name="nama_koordinator" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Uraian Kegiatan</label>
                    <textarea name="kegiatan" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan detail pekerjaan yang dilakukan hari ini..." required></textarea>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Dokumentasi (Opsional)</label>
                    <input type="file" name="foto_kegiatan" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition cursor-pointer">
                </div>

                {{-- AREA TANDA TANGAN --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Paraf Koordinator (Wajib Diisi)</label>
                    
                    {{-- Canvas Wrapper --}}
                    <div class="border-2 border-gray-400 border-dashed rounded-lg bg-white relative h-48 w-full touch-none">
                        <canvas id="signature-pad" class="w-full h-full block rounded-lg cursor-crosshair"></canvas>
                        
                        {{-- Placeholder Text --}}
                        <div id="signature-placeholder" class="absolute inset-0 flex items-center justify-center pointer-events-none text-gray-300 text-sm">
                            Tanda tangan disini
                        </div>

                        {{-- Tombol Reset --}}
                        <button type="button" id="clear-signature" class="absolute top-2 right-2 bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1 rounded text-xs font-bold border border-red-300 shadow-sm z-10">
                            Hapus
                        </button>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">*Jika tidak bisa dicoret, klik tombol <b>"Hapus"</b> sekali untuk mereset area.</p>
                    <input type="hidden" name="ttd_koordinator" id="ttd_input">
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-lg transition">Batal</button>
                    <button type="submit" id="save-logbook" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">Simpan Kegiatan</button>
                </div>
            </form>
        </div>
    </x-modal>

    {{-- SCRIPT SIGNATURE PAD --}}
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var canvas = document.getElementById('signature-pad');
            var placeholder = document.getElementById('signature-placeholder');
            
            // Inisialisasi Signature Pad
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)',
                velocityFilterWeight: 0.7
            });

            // Fungsi Resize agar ukuran canvas pas dengan layar (Responsive)
            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                
                // Simpan lebar container
                var containerWidth = canvas.parentElement.offsetWidth;
                var containerHeight = canvas.parentElement.offsetHeight;

                // Set dimensi canvas
                canvas.width = containerWidth * ratio;
                canvas.height = containerHeight * ratio;
                
                // Scale context
                canvas.getContext("2d").scale(ratio, ratio);
                
                // Reset (Data hilang saat resize, jadi harus hati-hati)
                signaturePad.clear(); 
            }

            // EVENT: Saat Modal Dibuka (PENTING AGAR TIDAK ERROR 0x0)
            window.addEventListener('open-modal', event => {
                if (event.detail == 'add-logbook') {
                    // Beri jeda sedikit agar animasi modal selesai, baru resize canvas
                    setTimeout(function() {
                        resizeCanvas();
                    }, 200); 
                }
            });

            // Hilangkan placeholder saat mulai menggambar
            signaturePad.addEventListener("beginStroke", () => {
                placeholder.style.display = "none";
            });

            // Tombol Clear
            document.getElementById('clear-signature').addEventListener('click', function () {
                signaturePad.clear();
                placeholder.style.display = "flex";
            });

            // Saat Form Submit
            document.getElementById('save-logbook').addEventListener('click', function (e) {
                e.preventDefault(); 
                
                if (signaturePad.isEmpty()) {
                    // Jika kosong, isi nilai kosong (nanti controller akan simpan NULL atau error jika required)
                    // Sebaiknya alert jika wajib
                    // alert("Mohon tanda tangan koordinator terlebih dahulu!");
                    // return;
                    document.getElementById('ttd_input').value = ""; 
                } else {
                    var dataURL = signaturePad.toDataURL('image/png');
                    document.getElementById('ttd_input').value = dataURL;
                }

                document.getElementById('logbookForm').submit();
            });
        });
    </script>
</x-app-layout>