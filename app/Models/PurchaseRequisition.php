<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    use HasFactory;
    protected $table = 'purchase_requisition';
    public $guarded = [];

    public function PurchaseRequisitionDetail()
    {
        return $this->hasMany(PurchaseRequisitionDetail::class, 'purchase_requisition_id');
    }
    public function PurchaseRequisitionImage()
    {
        return $this->hasMany(PurchaseRequisitionImage::class, 'purchase_requisition_id');
    }
}
