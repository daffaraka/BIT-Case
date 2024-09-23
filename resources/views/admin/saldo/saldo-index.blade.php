@extends('admin.admin-layout')
@section('content')
    <div class="my-3">
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Tambah Transaksi</a>
    </div>
    <div class="row mb-5">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Saldo Sekarang</h5>
                    <h2 class="card-text">Rp. {{number_format($saldo->saldo) ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Tetapkan saldo sekarang</h5>
            <form action="{{ route('saldo.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="">Saldo</label>
                    <input type="number" name="nominal" class="form-control" required>
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection
