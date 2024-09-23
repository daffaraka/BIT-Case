<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    protected $saldo;
    public function index()
    {
        $data['judul'] = 'Transaksi';
        $data['transaksis'] = Transaksi::with('user')->latest()->paginate(10);

        return view('admin.transaksi.transaksi-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['judul'] = 'Transaksi';
        $data['saldo'] = Saldo::first();
        return view('admin.transaksi.transaksi-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_transaksi' => 'required',
            'deskripsi_transaksi' => 'required',
            'nominal_transaksi' => 'required|numeric',
            'type_transaksi' => 'required',
        ]);

        $saldo = Saldo::first();
        $saldoAwal = $saldo->saldo;
        $saldoAkhir = 0;

        // dd($request->all());
        if ($request->type_transaksi == 'Pendapatan') {
            $saldoAkhir = $saldo->saldo + $request->nominal_transaksi;

            $saldo->saldo += $request->nominal_transaksi;
            $saldo->save();

        } else {
            $saldoAkhir = $saldo->saldo - $request->nominal_transaksi;

            $saldo->saldo -= $request->nominal_transaksi;
            $saldo->save();
        }

        if ($saldo->save()) {
            $transaksi = new Transaksi();
            $transaksi->user_id = auth()->user()->id;
            $transaksi->judul_transaksi = $request->judul_transaksi;
            $transaksi->saldo_awal = $saldoAwal;
            $transaksi->saldo_akhir = $saldoAkhir;
            $transaksi->deskripsi_transaksi = $request->deskripsi_transaksi;
            $transaksi->nominal_transaksi = $request->nominal_transaksi;
            $transaksi->type_transaksi = $request->type_transaksi;
            $transaksi->save();
        }



        return to_route('transaksi.index')->with('success', 'Data transaksi baru telah di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $data['saldo'] = Saldo::first();
        $data['judul'] = 'Edit transaksi';
        $data['transaksi'] = $transaksi;
        return view('admin.transaksi.transaksi-edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'judul_transaksi' => 'required',
            'deskripsi_transaksi' => 'required',
            'nominal_transaksi' => 'required|numeric',
            'type_transaksi' => 'required',
        ]);

        $saldo = Saldo::first();
        $saldoAwal = $saldo->saldo;
        $saldoAkhir = 0;

        $transaksiLama = Transaksi::find($transaksi->id);
        $nominalLama = $transaksiLama->nominal_transaksi;

        if ($request->type_transaksi == 'Pendapatan') {
            if ($request->nominal_transaksi == $nominalLama) {
                $saldoAkhir = $saldo->saldo;
            } elseif ($request->nominal_transaksi > $nominalLama) {
                $selisih = $request->nominal_transaksi - $nominalLama;
                $saldoAkhir = $saldo->saldo + $selisih;
                $saldo->saldo += $selisih;
            } else {
                $selisih = $nominalLama - $request->nominal_transaksi;
                $saldoAkhir = $saldo->saldo - $selisih;
                $saldo->saldo -= $selisih;
            }
        } else {
            if ($request->nominal_transaksi == $nominalLama) {
                $saldoAkhir = $saldo->saldo;
            } elseif ($request->nominal_transaksi > $nominalLama) {
                $selisih = $request->nominal_transaksi - $nominalLama;
                $saldoAkhir = $saldo->saldo - $selisih;
                $saldo->saldo -= $selisih;
            } else {
                $selisih = $nominalLama - $request->nominal_transaksi;
                $saldoAkhir = $saldo->saldo + $selisih;
                $saldo->saldo += $selisih;
            }
        }

        if ($saldo->save()) {
            $transaksi->user_id = auth()->user()->id;
            $transaksi->judul_transaksi = $request->judul_transaksi;
            $transaksi->saldo_awal = $saldoAwal;
            $transaksi->saldo_akhir = $saldoAkhir;
            $transaksi->deskripsi_transaksi = $request->deskripsi_transaksi;
            $transaksi->nominal_transaksi = $request->nominal_transaksi;
            $transaksi->type_transaksi = $request->type_transaksi;
            $transaksi->save();
        }

        return to_route('transaksi.index')->with('success', 'Data transaksi telah diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->back()->with('success','Transaksi berhasil di hapus');
    }



    public function filter()
    {
        $type = request()->query('type');

        if ($type) {
            $transaksis = Transaksi::where('type_transaksi', $type)->whereDate('created_at', request()->query('date'))->with('user')->get();
        } else {
            $transaksis = Transaksi::with('user')->get(); // Ambil semua transaksi jika tidak ada filter
        }

        return response()->json($transaksis);
    }

}
