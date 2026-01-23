<!DOCTYPE html>
<html>
<head>
    <title>Laporan Monitoring Kerja Praktek</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        
        /* HEADER */
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #000; 
            padding-bottom: 10px;
        }
        .header h2 { 
            margin: 0; 
            font-size: 16px; 
            text-transform: uppercase; 
            font-weight: bold;
        }
        .header h3 { 
            margin: 5px 0; 
            font-size: 12px; 
            font-weight: normal; 
            text-transform: uppercase;
        }

        /* TABEL INFORMASI */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .info-table td {
            padding: 3px;
            vertical-align: top;
        }
        .label {
            width: 160px;
            font-weight: bold;
        }
        .separator {
            width: 10px;
            text-align: center;
        }

        /* GAYA UNTUK SEMUA TABEL DATA (ABSEN & JURNAL) */
        .content-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .content-table th, .content-table td { 
            border: 1px solid #000; 
            padding: 5px; 
        }
        /* Header Tabel */
        .content-table th { 
            background-color: #f2f2f2; 
            text-align: center; 
            font-weight: bold;
            vertical-align: middle;
        }
        /* Isi Tabel Default (Rata Kiri Atas) */
        .content-table td {
            text-align: left; 
            vertical-align: top;
        }
        /* Helper Class */
        .text-center { text-align: center; }
        .align-middle { vertical-align: middle; }

        /* FOOTER */
        .footer { margin-top: 40px; width: 100%; }
        .ttd-box { 
            float: right;
            width: 250px;
            text-align: center; 
        }
    </style>
</head>
<body>

    {{-- 1. HEADER --}}
    <div class="header">
        <h2>MAGANG INDUSTRI PT. INDAHKIAT PULP AND PAPER Tbk PERAWANG</h2>
        <h3>MONITORING PELAKSANAAN KERJA PRAKTEK</h3>
    </div>

    {{-- 2. INFORMASI MAHASISWA --}}
    @php
        $sampleLog = $logbooks->first(); 
        $koordinator = $sampleLog ? $sampleLog->nama_koordinator : '-';
        $lokasiUnit  = $sampleLog ? $sampleLog->lokasi : $magang->jurusan; 
    @endphp

    <table class="info-table">
        <tr>
            <td class="label">Nama Mahasiswa</td>
            <td class="separator">:</td>
            <td>{{ $magang->user->name }}</td>
        </tr>
        <tr>
            <td class="label">NIM</td>
            <td class="separator">:</td>
            <td>{{ $magang->nim }}</td>
        </tr>
        <tr>
            <td class="label">Lembaga Pendidikan</td>
            <td class="separator">:</td>
            <td>{{ $magang->universitas }}</td>
        </tr>
        <tr>
            <td class="label">Jurusan / Prodi</td>
            <td class="separator">:</td>
            <td>{{ $magang->jurusan }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Praktek</td>
            <td class="separator">:</td>
            <td>{{ $periode }}</td> 
        </tr>
        <tr>
            <td class="label">Penempatan Unit</td>
            <td class="separator">:</td>
            <td>{{ $lokasiUnit }}</td>
        </tr>
        <tr>
            <td class="label">Koord. Lapangan</td>
            <td class="separator">:</td>
            <td>{{ $koordinator }}</td>
        </tr>
    </table>

    {{-- 3. BAGIAN A: REKAPITULASI KEHADIRAN (SAYA KEMBALIKAN KE SINI) --}}
    <h4>A. Rekapitulasi Kehadiran</h4>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Tanggal</th>
                <th width="20%">Jam Masuk</th>
                <th width="20%">Jam Pulang</th>
                <th width="25%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($presences as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('l, d F Y') }}</td>
                    <td class="text-center">{{ $p->jam_masuk }}</td>
                    <td class="text-center">{{ $p->jam_keluar ?? '-' }}</td>
                    <td class="text-center">{{ ucfirst($p->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 4. BAGIAN B: JURNAL KEGIATAN (VERSI FIX RATA TENGAH & TTD AMAN) --}}
    <h4>B. Jurnal Kegiatan Harian</h4>
    <table class="content-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Hari/Tanggal</th>
                <th width="15%">Jam Kerja</th>
                <th width="40%">Uraian Kegiatan</th>
                <th width="25%">Paraf Pembimbing</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $log)
                @php
                    $absen = $presences->where('tanggal', $log->tanggal)->first();
                    $jamMasuk = $absen ? $absen->jam_masuk : '-';
                    $jamKeluar = $absen ? ($absen->jam_keluar ?? '-') : '-';
                @endphp

                <tr>
                    {{-- No --}}
                    <td class="text-center">{{ $loop->iteration }}</td>
                    
                    {{-- Hari/Tanggal --}}
                    <td>{{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('l, d F Y') }}</td>
                    
                    {{-- Jam Kerja --}}
                    <td class="text-center">
                        {{ $jamMasuk }} - {{ $jamKeluar }}
                    </td>
                    
                    {{-- Uraian Kegiatan --}}
                    <td>
                        {{ $log->kegiatan }}
                    </td>
                    
                    {{-- Paraf Pembimbing (FIXED: Rata Tengah & Gambar Aman) --}}
                    <td style="text-align: center; vertical-align: middle;">
                        @if(!empty($log->ttd_koordinator))
                            @php
                                $ttd = $log->ttd_koordinator;
                                $finalPath = null;

                                // LOGIKA PENCARIAN FILE SUPER CHECK
                                if (\Illuminate\Support\Str::startsWith($ttd, 'data:image')) {
                                    $finalPath = $ttd;
                                } elseif (file_exists(storage_path('app/public/' . $ttd))) {
                                    $finalPath = storage_path('app/public/' . $ttd);
                                } elseif (file_exists(storage_path('app/' . $ttd))) {
                                    $finalPath = storage_path('app/' . $ttd);
                                } elseif (file_exists(public_path($ttd))) {
                                    $finalPath = public_path($ttd);
                                } elseif (file_exists(public_path('storage/' . $ttd))) {
                                    $finalPath = public_path('storage/' . $ttd);
                                }
                            @endphp

                            @if($finalPath)
                                <img src="{{ $finalPath }}" style="height: 40px; width: auto; display: inline-block;">
                            @else
                                <div style="color:red; font-size:8px;">File Error</div>
                            @endif
                        @else
                            {{-- Space kosong jika belum TTD --}}
                            <div style="height: 40px;"></div>
                        @endif
                        
                        {{-- Nama Koordinator --}}
                        <div style="font-size: 9px; margin-top: 5px; font-weight: bold;">
                            {{ $log->nama_koordinator }}
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data jurnal pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 5. FOOTER --}}
    <div class="footer">
        <div class="ttd-box">
            <p>Perawang, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,</p>
            <p style="font-weight: bold;">Public Relations (Humas)</p>
            <p>PT. Indah Kiat Pulp & Paper Tbk</p>
            <br><br><br><br>
            <p>( ................................................. )</p>
        </div>
    </div>

</body>
</html>