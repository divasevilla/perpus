@extends('layouts.app')
@section('title', 'Pengembalian Buku')
@section('sidebar-role', 'Portal Siswa')
@section('breadcrumb', 'Student / Pengembalian Buku')
@section('page-title', 'Pengembalian Buku')
@include('student._sidebar')

@section('topbar-actions')
    <a href="{{ route('student.books.index') }}" class="btn btn-primary" id="btn-pinjam-buku-baru">
        + Pinjam Buku
    </a>
@endsection

@section('content')
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                @php
                    $batas = $t->tanggal_pinjam?->addDays(7);
                    $telat = $t->status === 'dipinjam' && $batas?->isPast();
                @endphp
                <tr>
                    <td>{{ $transactions->firstItem() + $loop->index }}</td>
                    <td>
                        <strong>{{ $t->book->nama_buku ?? '-' }}</strong>
                        <div style="font-size:.72rem;color:var(--text-muted);">{{ $t->book->pengarang ?? '' }}</div>
                    </td>
                    <td>{{ $t->tanggal_pinjam?->format('d M Y') }}</td>
                    <td>
                        <span style="{{ $telat ? 'color:var(--danger);font-weight:700;' : '' }}">
                            {{ $batas?->format('d M Y') }}
                            @if($telat) ⚠️ @endif
                        </span>
                    </td>
                    <td>{{ $t->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
                    <td>
                        @if($t->status === 'dipinjam' && $telat)
                            @php $estimasi = $t->hitungDenda(); @endphp
                            <span style="color:var(--warning);font-weight:600;">~Rp {{ number_format($estimasi, 0, ',', '.') }}</span>
                        @elseif($t->denda > 0)
                            <span style="color:var(--danger);font-weight:600;">Rp {{ number_format($t->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    <td>
                        @if($t->status === 'dipinjam')
                        <form action="{{ route('student.transactions.kembali', $t->id_transaksi) }}" method="POST"
                              onsubmit="return confirm('Kembalikan buku ini?{{ $telat ? ' Akan ada denda keterlambatan.' : '' }}')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm" id="btn-kembali-{{ $t->id_transaksi }}">
                                Kembalikan
                            </button>
                        </form>
                        @elseif($t->status === 'menunggu')
                        <span style="color:var(--warning);font-size:.8rem;">Menunggu Acc</span>
                        @elseif($t->status === 'ditolak')
                        <span style="color:var(--danger);font-size:.8rem;">Ditolak</span>
                        @else
                        <span style="color:var(--text-muted);font-size:.8rem;">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--text-muted);padding:48px;">
                        <div style="font-size:2rem;margin-bottom:8px;">📚</div>
                        <p>Belum ada riwayat pinjam.</p>
                        <a href="{{ route('student.books.index') }}" style="color:var(--primary);font-size:.875rem;">Lihat katalog buku →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div style="margin-top:16px;">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
