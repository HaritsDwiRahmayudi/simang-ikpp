<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Absensi Kehadiran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Alert --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- KARTU ABSENSI HARI INI --}}
                <div class="md:col-span-1">
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                        <h3 class="text-lg font-bold text-gray-700 mb-2">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</h3>
                        
                        {{-- JAM DIGITAL REALTIME (Alpine.js) --}}
<div class="text-4xl font-extrabold text-blue-900 mb-6 font-mono"
     x-data="{ time: new Date().toLocaleTimeString('id-ID', { hour12: false }) }"
     x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', { hour12: false }), 1000)"
     x-text="time">
    {{ \Carbon\Carbon::now()->format('H:i:s') }}
</div>

                        {{-- LOGIKA TOMBOL --}}
                        @if(!$presenceToday)
                            {{-- JIKA BELUM ABSEN MASUK --}}
                            <form action="{{ route('presence.checkin') }}" method="POST">
                                @csrf
                                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                                    🌤 ABSEN MASUK
                                </button>
                            </form>
                        
                        @elseif(!$presenceToday->jam_keluar)
                            {{-- JIKA SUDAH MASUK, TAPI BELUM PULANG --}}
                            <div class="mb-4 text-green-600 font-bold bg-green-50 p-2 rounded">
                                ✅ Anda masuk pukul: {{ $presenceToday->jam_masuk }}
                            </div>
                            <form action="{{ route('presence.checkout') }}" method="POST">
                                @csrf @method('PATCH')
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                                    🏠 ABSEN PULANG
                                </button>
                            </form>
                        
                        @else
                            {{-- JIKA SUDAH SELESAI HARI INI --}}
                            <div class="bg-green-50 p-4 rounded border border-green-200">
                                <p class="text-green-800 font-bold">✅ Absensi Hari Ini Selesai</p>
                                <hr class="my-2 border-green-200">
                                <p class="text-sm">Masuk: {{ $presenceToday->jam_masuk }}</p>
                                <p class="text-sm">Pulang: {{ $presenceToday->jam_keluar }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TABEL RIWAYAT --}}
                <div class="md:col-span-2">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Riwayat Kehadiran</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Jam Masuk</th>
                                        <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Jam Pulang</th>
                                        <th class="px-4 py-2 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($history as $h)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ \Carbon\Carbon::parse($h->tanggal)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-gray-700 font-mono">{{ $h->jam_masuk }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-gray-700 font-mono">{{ $h->jam_keluar ?? '--:--' }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                {{ $h->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center text-gray-500 italic">Belum ada data absensi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>