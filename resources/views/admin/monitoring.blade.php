<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Mahasiswa Aktif') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nama Mahasiswa</th>
                                    <th class="py-3 px-6 text-left">Instansi / Kampus</th>
                                    <th class="py-3 px-6 text-left">Jurusan</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @forelse($mahasiswas as $m)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        
                                        {{-- 1. Nama Mahasiswa --}}
                                        <td class="py-3 px-6 text-left whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="font-medium font-bold text-gray-800">{{ $m->user->name }}</span>
                                            </div>
                                        </td>

                                        {{-- 2. Universitas --}}
                                        <td class="py-3 px-6 text-left">
                                            <span>{{ $m->universitas }}</span>
                                        </td>

                                        {{-- 3. Jurusan --}}
                                        <td class="py-3 px-6 text-left">
                                            <span>{{ $m->jurusan }}</span>
                                        </td>

                                        {{-- 4. AKSI (Hanya Tombol Detail) --}}
                                        <td class="py-3 px-6 text-center">
                                            <a href="{{ route('admin.monitoring.detail', $m->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs transition transform hover:scale-105 inline-flex items-center shadow">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Buka Detail & Validasi
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 px-6 text-center text-gray-500 italic">
                                            Tidak ada mahasiswa magang yang sedang aktif (Approved).
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>