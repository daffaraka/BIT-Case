@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="">Saldo awal</label>
            <input type="number" name="saldo_awal" class="form-control" readonly value="{{ $transaksi->saldo_awal ?? 0 }}">
        </div>


        <div class="mb-3">
            <label for="">Judul Transaksi</label>
            <input type="text" name="judul_transaksi" class="form-control" value="{{ $transaksi->judul_transaksi }}">
        </div>

        <div class="mb-3">
            <label for="">Deskripsi Transaksi</label>
            <textarea type="text" name="deskripsi_transaksi" class="form-control" cols="30" rows="3" >{{ $transaksi->deskripsi_transaksi }}</textarea>
        </div>



        <div class="mb-3">
            <label for="">Nominal Transaksi</label>
            <input type="text" name="nominal_transaksi" class="form-control" value="{{ $transaksi->nominal_transaksi }}">
        </div>

        <div class="mb-3">
            <label for="">Type Transaksi</label>
            <select name="type_transaksi" id="" class="form-control">
                <option value="Pendapatan" {{ $transaksi->type_transaksi == 'Pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                <option value="Pengeluaran" {{ $transaksi->type_transaksi == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>

            </select>
        </div>



        <button type="submit" class="btn btn-primary my-3" oncanplay="alert('Apakah anda yakin?')">Submit</button>
    </form>
@endsection

