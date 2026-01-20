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
                    
                    <form method="POST" action="{{ route('magang.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" value="{{ Auth::user()->name }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <p class="text-xs text-gray-500 mt-1">*Sesuai nama akun.</p>
                            </div>

                            <div>
                                <label for="nim" class="block text-sm font-medium text-gray-700">NIM / NPM</label>
                                <input type="text" name="nim" id="nim" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Contoh: 19010023">
                            </div>

                            <div>
                                <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan / Prodi</label>
                                <input type="text" name="jurusan" id="jurusan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Contoh: Teknik Informatika">
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label for="universitas" class="block text-sm font-medium text-gray-700">Asal Universitas / Sekolah</label>
                                <input type="text" name="universitas" id="universitas" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" placeholder="Contoh: Universitas Riau">
                            </div>

                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Rencana Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Rencana Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            </div>

                        </div> <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-blue-900 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-md shadow-lg transition duration-150 ease-in-out">
                                Kirim Pendaftaran
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>