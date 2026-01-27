<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LogbookController extends Controller
{
    /**
     * Menampilkan daftar logbook mahasiswa yang sedang login.
     */
    public function index()
    {
        $logs = Logbook::where('user_id', Auth::id())
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('logbook.index', compact('logs'));
    }

    /**
     * Menyimpan logbook baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'nama_koordinator' => 'required|string|max:255',
            'kegiatan' => 'required|string',
            'foto_kegiatan' => 'nullable|image|max:5120', // Max 5MB
            'ttd_koordinator' => 'nullable|string', // Data gambar base64 dari canvas
        ]);

        // 2. Handle Upload Foto Dokumentasi
        $fotoPath = null;
        if ($request->hasFile('foto_kegiatan')) {
            $fotoPath = $request->file('foto_kegiatan')->store('logbook-photos', 'public');
        }

        // 3. Handle Tanda Tangan (Base64 ke File Image)
        $ttdPath = null;
        if ($request->filled('ttd_koordinator')) {
            $image_parts = explode(";base64,", $request->ttd_koordinator);
            
            // PERBAIKAN: Validasi struktur base64 agar tidak error saat explode
            if (count($image_parts) == 2) {
                $image_base64 = base64_decode($image_parts[1]);
                
                $fileName = 'ttd-' . Str::random(20) . '.png';
                $path = 'logbook-ttd/' . $fileName;

                Storage::disk('public')->put($path, $image_base64);
                $ttdPath = $path;
            } else {
                return back()->with('error', 'Format tanda tangan tidak valid. Silakan coba lagi.');
            }
        }

        // 4. Simpan ke Database
        Logbook::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'nama_koordinator' => $request->nama_koordinator,
            'kegiatan' => $request->kegiatan,
            'foto_kegiatan' => $fotoPath,
            'ttd_koordinator' => $ttdPath,
        ]);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Logbook $logbook)
    {
        // Keamanan: Mahasiswa hanya boleh edit logbook miliknya sendiri
        if ($logbook->user_id !== Auth::id()) {
            abort(403);
        }
        return view('logbook.edit', compact('logbook'));
    }

    /**
     * Mengupdate data logbook.
     */
    public function update(Request $request, Logbook $logbook)
    {
        if ($logbook->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'nama_koordinator' => 'required|string|max:255',
            'kegiatan' => 'required|string',
            'foto_kegiatan' => 'nullable|image|max:2048',
        ]);

        // Data yang akan diupdate
        $data = $request->except(['foto_kegiatan', 'ttd_koordinator']);

        // Update Foto jika ada file baru
        if ($request->hasFile('foto_kegiatan')) {
            if ($logbook->foto_kegiatan) {
                Storage::delete('public/' . $logbook->foto_kegiatan);
            }
            $data['foto_kegiatan'] = $request->file('foto_kegiatan')->store('logbook-photos', 'public');
        }

        // Update Tanda Tangan jika ada input baru (Opsional pada saat edit)
        if ($request->filled('ttd_koordinator')) {
            $image_parts = explode(";base64,", $request->ttd_koordinator);
            if (count($image_parts) == 2) {
                if ($logbook->ttd_koordinator) {
                    Storage::delete('public/' . $logbook->ttd_koordinator);
                }
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'ttd-' . Str::random(20) . '.png';
                $path = 'logbook-ttd/' . $fileName;
                Storage::disk('public')->put($path, $image_base64);
                $data['ttd_koordinator'] = $path;
            }
        }

        $logbook->update($data);

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil diperbarui.');
    }

    /**
     * Menghapus data logbook.
     */
    public function destroy(Logbook $logbook)
    {
        if ($logbook->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file fisik dari storage agar tidak memenuhi server
        if ($logbook->foto_kegiatan) {
            Storage::delete('public/' . $logbook->foto_kegiatan);
        }

        if ($logbook->ttd_koordinator) {
            Storage::delete('public/' . $logbook->ttd_koordinator);
        }

        $logbook->delete();

        return redirect()->route('logbook.index')->with('success', 'Logbook berhasil dihapus.');
    }
}