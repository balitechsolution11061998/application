<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_detail_id',
        'nama',
        'hargaSatuan',
        'jumlahBarang',
        'hargaTotal',
        'diskon',
        'dpp',
        'ppn',
        'tarifPpnbm',
        'ppnbm',
    ];

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}
