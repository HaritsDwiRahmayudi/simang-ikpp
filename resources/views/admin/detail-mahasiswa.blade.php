<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail: {{ $magang->user->name }}</h2></x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- KOTAK VALIDASI --}}
            <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">Validasi Laporan Akhir</h3>
                    <p class="text-sm text-gray-600">Status saat ini: <strong class="uppercase">{{ $magang->status_laporan }}</strong></p>
                </div>
                <div class="flex gap-2">
                    {{-- Tombol Tolak --}}
                    <form action="{{ route('admin.laporan.approve', $magang->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status_laporan" value="rejected">
                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Tolak / Revisi</button>
                    </form>
                    {{-- Tombol Setujui --}}
                    <form action="{{ route('admin.laporan.approve', $magang->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status_laporan" value="approved">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold">✅ SETUJUI LAPORAN</button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                {{-- TABEL LOGBOOK --}}
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold mb-4">Riwayat Logbook</h3>
                    <ul class="list-disc ml-5 text-sm space-y-2">
                        @foreach($logs as $log)
                            <li>
                                <strong>{{ $log->tanggal }}:</strong> {{ Str::limit($log->kegiatan, 50) }}
                                <br><span class="text-xs text-gray-500">Paraf: {{ $log->nama_koordinator }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- TABEL ABSENSI --}}
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold mb-4">Riwayat Absensi</h3>
                    <table class="w-full text-sm">
                        @foreach($presences as $p)
                            <tr class="border-b">
                                <td class="py-1">{{ $p->tanggal }}</td>
                                <td class="py-1">{{ $p->jam_masuk }} - {{ $p->jam_keluar }}</td>
                                <td class="py-1 badge">{{ $p->status }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>