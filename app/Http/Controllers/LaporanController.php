<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Presence;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Panggil Library PDF

class LaporanController extends Controller
{
    public function downloadPdf()
    {
        $user = Auth::user();
        $magang = Magang::where('user_id', $user->id)->first();
        
        // Ambil Data Lengkap
        $logs = Logbook::where('user_id', $user->id)->orderBy('tanggal', 'asc')->get();
        $presences = Presence::where('user_id', $user->id)->orderBy('tanggal', 'asc')->get();

        // Load View PDF
        $pdf = Pdf::loadView('laporan.pdf_template', compact('user', 'magang', 'logs', 'presences'));
        
        // Set ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan-Magang-'.$user->name.'.pdf');
    }
}