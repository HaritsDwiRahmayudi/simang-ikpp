<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-blue-900 leading-tight">
            {{ __('Monitoring Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-xl text-gray-800">Daftar Mahasiswa Magang Aktif</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">Total: {{ count($mahasiswas) }}</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($mahasiswas as $m)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-xl transition duration-300 p-6 relative overflow-hidden group">
                                <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg shadow-sm">Aktif</div>
                                
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="h-14 w-14 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-2xl shadow-md">
                                        {{ substr($m->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-lg group-hover:text-blue-600 transition">{{ Str::limit($m->user->name, 18) }}</h4>
                                        <p class="text-xs text-gray-500 font-mono">{{ $m->nim }}</p>
                                    </div>
                                </div>
                                
                                <div class="text-sm text-gray-600 space-y-2 mb-6 border-t border-b border-gray-100 py-3">
                                    <p class="flex items-center"><span class="w-5 h-5 mr-2 text-blue-400">🏫</span> {{ Str::limit($m->universitas, 25) }}</p>
                                    <p class="flex items-center"><span class="w-5 h-5 mr-2 text-blue-400">📚</span> {{ Str::limit($m->jurusan, 25) }}</p>
                                </div>

                                <a href="{{ route('admin.monitoring.detail', $m->id) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg shadow transition transform hover:-translate-y-0.5">
                                    Lihat Aktivitas
                                </a>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-16">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="text-gray-500 text-lg">Belum ada mahasiswa aktif saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>