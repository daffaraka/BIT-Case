@extends('admin.admin-layout')
@section('content')
    <form action="{{ route('transaksi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="">Saldo awal</label>
            <input type="number" name="saldo_awal" class="form-control" readonly value="{{$saldo->saldo ?? 0}}">
        </div>


        <div class="mb-3">
            <label for="">Judul Transaksi</label>
            <input type="text" name="judul_transaksi" class="form-control">
        </div>

        <div class="mb-3">
            <label for="">Deskripsi Transaksi</label>
            <textarea type="text" name="deskripsi_transaksi" class="form-control" cols="30" rows="3" > </textarea>
        </div>



        <div class="mb-3">
            <label for="">Nominal Transaksi</label>
            <input type="text" name="nominal_transaksi" class="form-control">
        </div>

        <div class="mb-3">
            <label for="">Type Transaksi</label>
            <select name="type_transaksi" id="" class="form-control">
                <option value="Pendapatan">Pendapatan</option>
                <option value="Pengeluaran">Pengeluaran</option>

            </select>
        </div>



        <button type="submit" class="btn btn-primary my-3" oncanplay="alert('Apakah anda yakin?')">Submit</button>
    </form>
@endsection
