<?php

namespace App\Http\Controllers;

use App\Barang;
use App\DetailPenjualan;
use App\DetailPenjualanPos;
use App\Hpp;
use Auth;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanLabaKotorProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware('user-must-warung');
    }

    public function pilihProduk()
    {
        $produk       = Barang::select(['id', 'nama_barang'])->where('id_warung', Auth::user()->id_warung)->get();
        $array_produk = array();
        foreach ($produk as $produks) {
            array_push($array_produk, [
                'id'          => $produks->id,
                'nama_produk' => title_case($produks->nama_barang),
                ]);
        }
        return response()->json($array_produk);
    }

    public function dataPagination($laporan_laba_kotor, $array_laba_kotor, $link_view)
    {

        $respons['current_page']   = $laporan_laba_kotor->currentPage();
        $respons['data']           = $array_laba_kotor;
        $respons['first_page_url'] = url('/laporan-laba-kotor-produk/' . $link_view . '?page=' . $laporan_laba_kotor->firstItem());
        $respons['from']           = 1;
        $respons['last_page']      = $laporan_laba_kotor->lastPage();
        $respons['last_page_url']  = url('/laporan-laba-kotor-produk/' . $link_view . '?page=' . $laporan_laba_kotor->lastPage());
        $respons['next_page_url']  = $laporan_laba_kotor->nextPageUrl();
        $respons['path']           = url('/laporan-laba-kotor-produk/' . $link_view . '');
        $respons['per_page']       = $laporan_laba_kotor->perPage();
        $respons['prev_page_url']  = $laporan_laba_kotor->previousPageUrl();
        $respons['to']             = $laporan_laba_kotor->perPage();
        $respons['total']          = $laporan_laba_kotor->total();

        return $respons;
    }

    public function subtotalLaporan($sub_hpp, $sub_total_penjualan)
    {
        if ($sub_hpp->total_hpp == "" || $sub_total_penjualan->subtotal == "" || $sub_hpp->total_hpp == 0 || $sub_total_penjualan->subtotal == 0) {
            $subtotal_hpp                   = 0;
            $subtotal_penjualan             = 0;
            $subtotal_laba_kotor            = 0;
            $subtotal_persentase_laba_kotor = 0;
            $subtotal_persentase_gpm        = 0;
        } else {
            $subtotal_hpp                   = $sub_hpp->total_hpp;
            $subtotal_penjualan             = $sub_total_penjualan->subtotal;
            $subtotal_laba_kotor            = $subtotal_penjualan - $subtotal_hpp;
            $subtotal_persentase_laba_kotor = ($subtotal_laba_kotor * 100) / $subtotal_hpp;
            $subtotal_persentase_gpm        = ($subtotal_laba_kotor * 100) / $subtotal_penjualan;
        }

        $response['subtotal_hpp']                   = $subtotal_hpp;
        $response['subtotal_penjualan']             = $subtotal_penjualan;
        $response['subtotal_laba_kotor']            = $subtotal_laba_kotor;
        $response['subtotal_persentase_laba_kotor'] = $subtotal_persentase_laba_kotor;
        $response['subtotal_persentase_gpm']        = $subtotal_persentase_gpm;

        return $response;
    }

//METHOD UNTUK TABEL PENJUALAN POS (OFLLINE)

    public function prosesLaporanLabaKotorProduk(Request $request)
    {
        $laporan_laba_kotor = DetailPenjualanPos::laporanLabaKotorProdukPos($request)->paginate(10);

        $array_laba_kotor = array();
        foreach ($laporan_laba_kotor as $laba_kotor) {
            //HPP
            $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor->id_produk)->where('jenis_transaksi', 'PenjualanPos')->where('warung_id', Auth::user()->id_warung)->first();
            $total_hpp             = $hpp_masuk->hpp;
            $total_laba_kotor      = $laba_kotor->subtotal - $total_hpp;
            $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
            $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor->subtotal;

            array_push($array_laba_kotor, ['laba_kotor' => $laba_kotor, 'hpp' => $total_hpp, 'total_laba_kotor' => $total_laba_kotor, 'persentase_laba_kotor' => $persentase_laba_kotor, 'persentase_gpm' => $persentase_gpm]);
        }

        $link_view = 'view';

        //DATA PAGINATION
        $respons = $this->dataPagination($laporan_laba_kotor, $array_laba_kotor, $link_view);
        return response()->json($respons);
    }

    public function pencarian(Request $request)
    {
        $laporan_laba_kotor = DetailPenjualanPos::cariLaporanLabaKotorProdukPos($request)->paginate(10);

        $array_laba_kotor = array();
        foreach ($laporan_laba_kotor as $laba_kotor) {
            //HPP
            $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor->id_produk)->where('jenis_transaksi', 'PenjualanPos')->where('warung_id', Auth::user()->id_warung)->first();
            $total_hpp             = $hpp_masuk->hpp;
            $total_laba_kotor      = $laba_kotor->subtotal - $total_hpp;
            $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
            $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor->subtotal;

            array_push($array_laba_kotor, ['laba_kotor' => $laba_kotor, 'hpp' => $total_hpp, 'total_laba_kotor' => $total_laba_kotor, 'persentase_laba_kotor' => $persentase_laba_kotor, 'persentase_gpm' => $persentase_gpm]);
        }

        $link_view = 'view';

        //DATA PAGINATION
        $respons = $this->dataPagination($laporan_laba_kotor, $array_laba_kotor, $link_view);
        return response()->json($respons);
    }

    public function subtotalLabaKotorProduk(Request $request)
    {
        //SUBTOTAL KESELURUHAN
        $sub_total_penjualan = DetailPenjualanPos::subtotalLaporanLabaKotorProduk($request)->first();

        //TOTAL HPP /PRODUK KESELURUHAN
        $jenis_transaksi = "PenjualanPos";
        $sub_hpp         = Hpp::hppLaporanLabaKotorProduk($request, $jenis_transaksi)->first();

        $response = $this->subtotalLaporan($sub_hpp, $sub_total_penjualan);

        return response()->json($response);
    }

//METHOD UNTUK TABEL PENJUALAN POS (OFLLINE)

//METHOD UNTUK TABEL PENJUALAN PESANAN (ONLINE)

    public function prosesLaporanLabaKotorProdukPesanan(Request $request)
    {
        $laporan_laba_kotor = DetailPenjualan::laporanLabaKotorProdukPesanan($request)->paginate(10);

        $array_laba_kotor = array();
        foreach ($laporan_laba_kotor as $laba_kotor) {
            //HPP
            $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor->id_produk)->where('jenis_transaksi', 'penjualan')->where('warung_id', Auth::user()->id_warung)->first();
            $total_hpp             = $hpp_masuk->hpp;
            $total_laba_kotor      = $laba_kotor->subtotal - $total_hpp;
            $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
            $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor->subtotal;

            array_push($array_laba_kotor, ['laba_kotor' => $laba_kotor, 'hpp' => $total_hpp, 'total_laba_kotor' => $total_laba_kotor, 'persentase_laba_kotor' => $persentase_laba_kotor, 'persentase_gpm' => $persentase_gpm]);
        }

        $link_view = 'view-pesanan';

        //DATA PAGINATION
        $respons = $this->dataPagination($laporan_laba_kotor, $array_laba_kotor, $link_view);
        return response()->json($respons);
    }

    public function pencarianPesanan(Request $request)
    {
        $laporan_laba_kotor = DetailPenjualan::cariLaporanLabaKotorProdukPesanan($request)->paginate(10);

        $array_laba_kotor = array();
        foreach ($laporan_laba_kotor as $laba_kotor) {
            //HPP
            $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor->id_produk)->where('jenis_transaksi', 'penjualan')->where('warung_id', Auth::user()->id_warung)->first();
            $total_hpp             = $hpp_masuk->hpp;
            $total_laba_kotor      = $laba_kotor->subtotal - $total_hpp;
            $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
            $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor->subtotal;

            array_push($array_laba_kotor, ['laba_kotor' => $laba_kotor, 'hpp' => $total_hpp, 'total_laba_kotor' => $total_laba_kotor, 'persentase_laba_kotor' => $persentase_laba_kotor, 'persentase_gpm' => $persentase_gpm]);
        }

        $link_view = 'view-pesanan';

        //DATA PAGINATION
        $respons = $this->dataPagination($laporan_laba_kotor, $array_laba_kotor, $link_view);
        return response()->json($respons);
    }

    public function subtotalLabaKotorProdukPesanan(Request $request)
    {
        //SUBTOTAL KESELURUHAN
        $sub_total_penjualan = DetailPenjualan::subtotalLaporanLabaKotorProdukPesanan($request)->first();

        //TOTAL HPP /PRODUK KESELURUHAN
        $jenis_transaksi = "penjualan";
        $sub_hpp         = Hpp::hppLaporanLabaKotorProduk($request, $jenis_transaksi)->first();

        $response = $this->subtotalLaporan($sub_hpp, $sub_total_penjualan);

        return response()->json($response);
    }
//METHOD UNTUK TABEL PENJUALAN PESANAN (ONLINE)

    public function labelSheet($sheet, $row)
    {
        $sheet->row($row, [
            'Kode Produk',
            'Nama Produk',
            'Hpp',
            'Penjualan',
            'Laba Kotor',
            'Laba Kotor (%)',
            'Gross Profit Margin (%)',
            ]);
        return $sheet;
    }

    //DOWNLOAD EXCEL - LAPORAN LABA KOTOR /PRODUK
    public function downloadExcel(Request $request, $dari_tanggal, $sampai_tanggal, $produk)
    {
        $request['dari_tanggal']   = $dari_tanggal;
        $request['sampai_tanggal'] = $sampai_tanggal;
        $request['produk']      = $produk;

    //QUERY LABA KOTOR POS
        $laporan_laba_kotor = DetailPenjualanPos::laporanLabaKotorProdukPos($request);
        $sub_total_penjualan = DetailPenjualanPos::subtotalLaporanLabaKotorProduk($request)->first();
        $jenis_transaksi = "PenjualanPos";
        $sub_hpp         = Hpp::hppLaporanLabaKotorProduk($request, $jenis_transaksi)->first();
    //QUERY LABA KOTOR POS

    //QUERY LABA KOTOR PESANAN
        $laporan_laba_kotor_pesanan = DetailPenjualan::laporanLabaKotorProdukPesanan($request);
        $sub_total_penjualan_pesanan = DetailPenjualan::subtotalLaporanLabaKotorProdukPesanan($request)->first();
        $jenis_transaksi = "penjualan";
        $sub_hpp_pesanan         = Hpp::hppLaporanLabaKotorProduk($request, $jenis_transaksi)->first();
    //QUERY LABA KOTOR PESANAN

        Excel::create('Laporan Laba Kotor Produk', function ($excel) use ($laporan_laba_kotor, $request, $sub_total_penjualan, $sub_hpp, $laporan_laba_kotor_pesanan, $sub_total_penjualan_pesanan, $sub_hpp_pesanan) {
            // Set property
            $excel->sheet('Laporan Laba Kotor Produk', function ($sheet) use ($laporan_laba_kotor, $request, $sub_total_penjualan, $sub_hpp, $laporan_laba_kotor_pesanan, $sub_total_penjualan_pesanan, $sub_hpp_pesanan) {
                $row = 1;
                $sheet->row($row, [
                    'LABA KOTOR PENJUALAN POS',
                    ]);

                $row = 3;                
                $sheet = $this->labelSheet($sheet, $row);

                if ($laporan_laba_kotor->count() > 0) { //MENCEGAH JIKA DATA KOSONG KETIKA DI DOWLOAD, AGAR TIDAK ERROR
                    
                    //LABA KOTOR /PRODUK
                    foreach ($laporan_laba_kotor->get() as $laba_kotor) {
                        $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor->id_produk)->where('jenis_transaksi', 'PenjualanPos')->where('warung_id', Auth::user()->id_warung)->first();
                        $total_hpp             = $hpp_masuk->hpp;
                        $total_laba_kotor      = $laba_kotor->subtotal - $total_hpp;
                        $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
                        $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor->subtotal;

                        $sheet->row(++$row, [
                            $laba_kotor->kode_barang,
                            $laba_kotor->nama_barang,
                            $total_hpp = round($total_hpp, 2),
                            $laba_kotor->subtotal = round($laba_kotor->subtotal, 2),
                            $total_laba_kotor = round($total_laba_kotor, 2),
                            $persentase_laba_kotor = round($persentase_laba_kotor, 2),
                            $persentase_gpm = round($persentase_gpm, 2),
                            ]);
                    }

                    $sheet->row(++$row, [
                        'TOTAL',
                        '',
                        $subtotal_hpp                   = round($sub_hpp->total_hpp ,2 ),
                        $subtotal_penjualan             = round($sub_total_penjualan->subtotal ,2 ),
                        $subtotal_laba_kotor            = round($subtotal_penjualan - $subtotal_hpp ,2 ),
                        $subtotal_persentase_laba_kotor = round(($subtotal_laba_kotor * 100) / $subtotal_hpp ,2 ),
                        $subtotal_persentase_gpm        = round(($subtotal_laba_kotor * 100) / $subtotal_penjualan ,2 ),
                        ]);
                }

                $row = ++$row + 3;
                $sheet->row($row, [
                    'LABA KOTOR PENJUALAN ONLINE',
                    ]);

                $row = ++$row + 1;
                
                $sheet = $this->labelSheet($sheet, $row);

                if ($laporan_laba_kotor_pesanan->count() > 0) { //MENCEGAH JIKA DATA KOSONG KETIKA DI DOWLOAD, AGAR TIDAK ERROR

                    //LABA KOTOR /PRODUK
                    foreach ($laporan_laba_kotor_pesanan->get() as $laba_kotor_pesanan) {
                        $hpp_masuk             = Hpp::select(DB::raw('SUM(total_nilai) as hpp'))->where('id_produk', $laba_kotor_pesanan->id_produk)->where('jenis_transaksi', 'penjualan')->where('warung_id', Auth::user()->id_warung)->first();
                        $total_hpp             = $hpp_masuk->hpp;
                        $total_laba_kotor      = $laba_kotor_pesanan->subtotal - $total_hpp;
                        $persentase_laba_kotor = ($total_laba_kotor * 100) / $total_hpp;
                        $persentase_gpm        = ($total_laba_kotor * 100) / $laba_kotor_pesanan->subtotal;

                        $sheet->row(++$row, [
                            $laba_kotor_pesanan->kode_barang,
                            $laba_kotor_pesanan->nama_barang,
                            $total_hpp = round($total_hpp, 2),
                            $laba_kotor_pesanan->subtotal = round($laba_kotor_pesanan->subtotal, 2),
                            $total_laba_kotor = round($total_laba_kotor, 2),
                            $persentase_laba_kotor = round($persentase_laba_kotor, 2),
                            $persentase_gpm = round($persentase_gpm, 2),
                            ]);
                    }

                    $sheet->row(++$row, [
                        'TOTAL',
                        '',
                        $subtotal_hpp                   = round($sub_hpp_pesanan->total_hpp ,2 ),
                        $subtotal_penjualan             = round($sub_total_penjualan_pesanan->subtotal ,2 ),
                        $subtotal_laba_kotor            = round($subtotal_penjualan - $subtotal_hpp ,2 ),
                        $subtotal_persentase_laba_kotor = round(($subtotal_laba_kotor * 100) / $subtotal_hpp ,2 ),
                        $subtotal_persentase_gpm        = round(($subtotal_laba_kotor * 100) / $subtotal_penjualan ,2 ),
                        ]);

                }
            });
})->export('xls');
}
}