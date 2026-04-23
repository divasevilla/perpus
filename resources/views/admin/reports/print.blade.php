<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f5; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>Laporan Peminjaman Perpustakaan</h2>
        <p>
            @if(request('start_date') && request('end_date'))
                Periode: {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
            @else
                Semua Periode
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">No</th>
                <th style="width: 20%">Anggota</th>
                <th style="width: 30%">Judul Buku</th>
                <th style="width: 15%">Tgl Pinjam</th>
                <th style="width: 15%">Tgl Kembali</th>
                <th class="text-right" style="width: 15%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse($transactions as $t)
                @php $totalDenda += $t->denda; @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $t->mahasiswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $t->book->nama_buku ?? '-' }}</td>
                    <td>{{ $t->tanggal_pinjam?->format('d/m/Y') }}</td>
                    <td>{{ $t->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                    <td class="text-right">{{ $t->denda > 0 ? number_format($t->denda, 0, ',', '.') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan Denda</th>
                <th class="text-right">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>