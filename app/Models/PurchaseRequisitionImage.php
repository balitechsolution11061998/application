<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisitionImage extends Model
{
    use HasFactory;
    protected $table = 'purchase_requisition_image';
    public $guarded = [];
}
