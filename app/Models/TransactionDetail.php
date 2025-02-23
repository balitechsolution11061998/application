<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'kdJenisTransaksi',
        'fgPengganti',
        'nomorFaktur',
        'tanggalFaktur',
        'npwpPenjual',
        'namaPenjual',
        'alamatPenjual',
        'npwpLawanTransaksi',
        'namaLawanTransaksi',
        'alamatLawanTransaksi',
        'jumlahDpp',
        'jumlahPpn',
        'jumlahPpnBm',
        'statusApproval',
        'statusFaktur',
        'referensi',
    ];

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
