<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Imagick;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Reader\QrCodeReader;
use Zxing\QrReader;
use SimpleXMLElement;
use Yajra\DataTables\Facades\DataTables;

class TandaTerimaController extends Controller
{
    public function index()
    {
        return view('tanda-terima.index');
    }

    public function storeFakturPajak(Request $request)
    {
        $data = $request->input('resValidateFakturPm');
    
        // Flatten the main transaction details
        $transactionDetailData = [
            'kdJenisTransaksi' => $data['kdJenisTransaksi']['#text'],
            'fgPengganti' => $data['fgPengganti']['#text'],
            'nomorFaktur' => $data['nomorFaktur']['#text'],
            'tanggalFaktur' => Carbon::createFromFormat('d/m/Y', $data['tanggalFaktur']['#text'])->toDateString(),
            'npwpPenjual' => $data['npwpPenjual']['#text'],
            'namaPenjual' => $data['namaPenjual']['#text'],
            'alamatPenjual' => $data['alamatPenjual']['#text'],
            'npwpLawanTransaksi' => $data['npwpLawanTransaksi']['#text'],
            'namaLawanTransaksi' => $data['namaLawanTransaksi']['#text'],
            'alamatLawanTransaksi' => $data['alamatLawanTransaksi']['#text'],
            'jumlahDpp' => (float) $data['jumlahDpp']['#text'],
            'jumlahPpn' => (float) $data['jumlahPpn']['#text'],
            'jumlahPpnBm' => (float) $data['jumlahPpnBm']['#text'],
            'statusApproval' => $data['statusApproval']['#text'],
            'statusFaktur' => $data['statusFaktur']['#text'],
            'referensi' => $data['referensi']['#text'],
        ];
    
        // Insert the main transaction detail
        $transactionDetail = TransactionDetail::create($transactionDetailData);
    
        // Flatten and insert transaction items
        foreach ($data['detailTransaksi'] as $item) {
            $transactionItemData = [
                'transaction_detail_id' => $transactionDetail->id,
                'nama' => $item['nama']['#text'],
                'hargaSatuan' => (float) $item['hargaSatuan']['#text'],
                'jumlahBarang' => (int) $item['jumlahBarang']['#text'],
                'hargaTotal' => (float) $item['hargaTotal']['#text'],
                'diskon' => (float) $item['diskon']['#text'],
                'dpp' => (float) $item['dpp']['#text'],
                'ppn' => (float) $item['ppn']['#text'],
                'tarifPpnbm' => (float) $item['tarifPpnbm']['#text'],
                'ppnbm' => (float) $item['ppnbm']['#text'],
            ];
    
            TransactionItem::create($transactionItemData);
        }
    
        return response()->json(['nomorFaktur' => $transactionDetail->nomorFaktur], 200);
    }
    
    public function getDataFakturPajak(Request $request)
    {
        $fakturPajaks = TransactionDetail::query();

        return DataTables::of($fakturPajaks)
            ->make(true);
    }
    
    
    
}
