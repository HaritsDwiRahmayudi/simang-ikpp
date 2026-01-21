<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Wajib untuk fitur upload

class LogbookController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Profil Magang (Untuk Header Otomatis)
        $profil = Magang::where('user_id', Auth::id())->first();

        // 2. Ambil Riwayat Logbook User Ini
        $logs = Logbook::where('user_id', Auth::id())
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('logbook.index', compact('logs', 'profil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|min:10',
            'nama_koordinator' => 'required|string',
            'lokasi' => 'required|string',
            'ttd_koordinator' => 'required', // Tanda tangan wajib
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi Foto (Max 2MB)
        ]);

        // Proses Upload Foto (Jika ada)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan ke folder 'public/logbooks'
            $fotoPath = $request->file('foto')->store('logbooks', 'public');
        }

        Logbook::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'nama_koordinator' => $request->nama_koordinator,
            'lokasi' => $request->lokasi,
            'ttd_koordinator' => $request->ttd_koordinator,
            'foto_kegiatan' => $fotoPath, // Simpan alamat file foto
        ]);

        return redirect()->back()->with('success', 'Logbook berhasil disimpan!');
    }

    public function destroy($id)
    {
        $log = Logbook::where('user_id', Auth::id())->findOrFail($id);
        
        // Hapus file foto dari penyimpanan agar hemat memori
        if ($log->foto_kegiatan) {
            Storage::disk('public')->delete($log->foto_kegiatan);
        }

        $log->delete();
        return redirect()->back()->with('success', 'Logbook dihapus.');
    }
}