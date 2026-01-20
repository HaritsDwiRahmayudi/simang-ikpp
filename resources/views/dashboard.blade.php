<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500 mt-2">Berikut adalah informasi status pendaftaran magang Anda di PT. IKPP.</p>
                    </div>

                    <hr class="mb-8 border-gray-200">

                    <div class="flex justify-center">
                        @if($magang)
                            
                            {{-- STATUS: PENDING --}}
                            @if($magang->status == 'pending')
                                <div class="max-w-2xl w-full bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-10 w-10 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg leading-6 font-bold text-yellow-800">
                                                Status: MENUNGGU PERSETUJUAN (PENDING)
                                            </h3>
                                            <p class="mt-2 text-sm text-yellow-700">
                                                Berkas pendaftaran Anda telah kami terima. Tim HRD sedang melakukan verifikasi data. Mohon cek berkala dalam 1-3 hari kerja.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            
                            {{-- STATUS: APPROVED (DITERIMA) --}}
                            @elseif($magang->status == 'approved')
                                <div class="max-w-2xl w-full bg-green-50 border-l-4 border-green-400 p-6 rounded-r shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-10 w-10 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg leading-6 font-bold text-green-800">
                                                Status: DITERIMA / APPROVED
                                            </h3>
                                            <p class="mt-2 text-sm text-green-700">
                                                Selamat! Pengajuan magang Anda diterima. Silahkan cek email Anda untuk Surat Penerimaan dan instruksi selanjutnya.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            {{-- STATUS: REJECTED (DITOLAK) --}}
                            @else
                                <div class="max-w-2xl w-full bg-red-50 border-l-4 border-red-400 p-6 rounded-r shadow-sm">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-10 w-10 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg leading-6 font-bold text-red-800">
                                                Status: DITOLAK / REJECTED
                                            </h3>
                                            <p class="mt-2 text-sm text-red-700">
                                                Mohon maaf, kualifikasi atau kuota magang belum sesuai dengan kebutuhan perusahaan saat ini. Tetap semangat!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @else
                            {{-- JIKA BELUM DAFTAR (Tombol Besar) --}}
                            <div class="text-center">
                                <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 mb-6">
                                    <p class="text-gray-600 mb-4">Anda belum terdaftar dalam program magang periode ini. Silahkan lengkapi data diri Anda.</p>
                                    
                                    <a href="{{ route('magang.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-900 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-blue-800 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg transform hover:-translate-y-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Isi Formulir Pendaftaran
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>