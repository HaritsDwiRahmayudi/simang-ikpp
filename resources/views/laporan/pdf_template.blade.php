<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kegiatan Magang</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        h2, h3 { text-align: center; margin: 0; }
        .watermark {
            position: fixed; top: 30%; left: 20%; font-size: 100px; color: rgba(255, 0, 0, 0.2);
            transform: rotate(-45deg); z-index: -1;
        }
    </style>
</head>
<body>
    {{-- LOGIKA CAP / WATERMARK --}}
    @if($magang->status_laporan != 'approved')
        <div class="watermark">DRAFT / BELUM ACC</div>
    @endif

    <div style="text-align: center; margin-bottom: 30px;">
        <h2>LAPORAN KEGIATAN MAGANG</h2>
        <h3>PT. INDAH KIAT PULP & PAPER</h3>
        <p>Nama: {{ $user->name }} | NIM: {{ $magang->nim }}</p>
    </div>

    <h4>A. Rekapitulasi Kehadiran</h4>
    <table>
        <tr style="background: #eee;">
            <th>Tanggal</th><th>Jam Masuk</th><th>Jam Pulang</th><th>Status</th>
        </tr>
        @foreach($presences as $p)
        <tr>
            <td>{{ $p->tanggal }}</td><td>{{ $p->jam_masuk }}</td><td>{{ $p->jam_keluar }}</td><td>{{ $p->status }}</td>
        </tr>
        @endforeach
    </table>

    <h4>B. Jurnal Kegiatan Harian</h4>
    <table>
        <tr style="background: #eee;">
            <th>Tanggal</th><th>Kegiatan</th><th>Paraf Lapangan</th>
        </tr>
        @foreach($logs as $l)
        <tr>
            <td>{{ $l->tanggal }}</td>
            <td>{{ $l->kegiatan }}</td>
            <td style="text-align: center;">
                @if($l->ttd_koordinator)
                    <img src="{{ public_path('storage/'.$l->ttd_koordinator) }}" style="height: 30px;">
                    <br><span style="font-size: 9px;">{{ $l->nama_koordinator }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </table>

    {{-- TANDA TANGAN VALIDASI ADMIN (Hanya muncul jika approved) --}}
    @if($magang->status_laporan == 'approved')
        <div style="float: right; text-align: center; margin-top: 50px; width: 200px;">
            <p>Disetujui Oleh Admin HRD,</p>
            <br><br><br>
            <p><strong>( Tanda Tangan Valid )</strong></p>
            <p>Date: {{ date('d-m-Y') }}</p>
        </div>
    @endif
</body>
</html>