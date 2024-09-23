@extends('admin.admin-layout')
@section('content')
    <div class="my-3">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="">Filter tipe transaksi</label>
                    <select name="type" id="type" class="form-control">
                        <option value="">Semua</option>
                        <option value="Pendapatan">Pendapatan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-dark mt-4" id="btnFilter">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-light" id="dataTable">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Judul transaksi</th>
                <th>Saldo awal</th>
                <th>Saldo akhir</th>
                <th>Nominal Transaksi</th>
                <th>Type Transaksi</th>
                <th>Akun transaksi</th>
                <th>Tanggal ditambahkan</th>
                <th>Aksi</th> <!-- Kolom untuk aksi -->
            </tr>
        </thead>
        <tbody id="tbody-transaksi">
            @foreach ($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksi->judul_transaksi }}</td>
                    <td>Rp.{{ number_format($transaksi->saldo_awal, 0, ',', '.') }}</td>
                    <td>Rp.{{ number_format($transaksi->saldo_akhir, 0, ',', '.') }}</td>
                    <td>
                        @if ($transaksi->type_transaksi == 'Pendapatan')
                            <b>+</b> Rp.{{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}
                        @else
                            <b>-</b> Rp.{{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if ($transaksi->type_transaksi == 'Pendapatan')
                            <button type="button" class="btn btn-success btn-sm">{{ $transaksi->type_transaksi }}</button>
                        @else
                            <button type="button" class="btn btn-warning btn-sm">{{ $transaksi->type_transaksi }}</button>
                        @endif
                    </td>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->isoFormat('HH:mm:ss, dddd, D MMMM Y') }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $('#btnFilter').on('click', function() {
            var type = $('#type').val();
            var date = $('#date').val();
            $.ajax({
                url: "{{ route('transaksi.filter') }}",
                type: "GET",
                data: {
                    type: type,
                    date: date
                },
                success: function(data) {
                    $('#tbody-transaksi').empty();
                    $.each(data, function(index, item) {
                        let createdAt = new Date(item.created_at).toLocaleString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                        $('#tbody-transaksi').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.judul_transaksi}</td>
                        <td>Rp.${item.saldo_awal.toLocaleString('id-ID')}</td>
                        <td>Rp.${item.saldo_akhir.toLocaleString('id-ID')}</td>
                        <td>${item.nominal_transaksi < 0 ? `<b>-</b> ` : `<b>+</b> `}Rp.${Math.abs(item.nominal_transaksi).toLocaleString('id-ID')}</td>
                        <td><button type="button" class="btn btn-${item.type_transaksi == 'Pendapatan' ? 'success' : 'warning'} btn-sm">${item.type_transaksi}</button></td>
                        <td>${item.user.name}</td>
                        <td>${createdAt}</td>
                        <td>
                            <a href="/transaksi/${item.id}/edit" class="btn btn-warning">Edit</a>
                            <form action="/transaksi/${item.id}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                `);
                    });
                }
            });
        });
    </script>
@endsection
