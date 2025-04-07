<?php

namespace App\Repositories\OrdSku;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdSku;
use App\Models\OrdHead;
use Illuminate\Support\Facades\Schema;

class OrdSkuRepositoryImplement extends Eloquent implements OrdSkuRepository
{
    protected OrdSku $model;

    public function __construct(OrdSku $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate($data)
    {
        // Determine if ordhead uses id or ordid
        $ordheadPrimaryKey = $this->getOrdheadPrimaryKey();

        // Ensure ordhead_id is set correctly based on ordhead's primary key
        if ($ordheadPrimaryKey === 'ordid' && isset($data['ordhead_id'])) {
            // If ordhead uses ordid, we can use the value directly
            $ordheadId = $data['ordhead_id'];
        } else {
            // If ordhead uses id, we need to find the corresponding ordhead
            $ordhead = OrdHead::where('order_no', $data['order_no'])->first();
            $ordheadId = $ordhead ? $ordhead->{$ordheadPrimaryKey} : null;
        }

        // Prepare the where clause
        $whereClause = [
            'order_no' => $data['order_no'],
            'sku' => $data['sku'],
            'upc' => $data['upc'],
        ];

        // Only include ordhead_id in where clause if it's set
        if ($ordheadId) {
            $whereClause['ordhead_id'] = $ordheadId;
        }

        // Prepare the update data
        $updateData = [
            'sku_desc' => $data['sku_desc'],
            'tag_code' => $data['tag_code'],
            'unit_cost' => $data['unit_cost'],
            'unit_retail' => $data['unit_retail'],
            'vat_cost' => $data['vat_cost'],
            'luxury_cost' => $data['luxury_cost'],
            'qty_ordered' => $data['qty_ordered'],
            'qty_received' => $data['qty_received'],
            'unit_discount' => $data['unit_discount'],
            'unit_permanent_discount' => $data['unit_permanent_discount'],
            'purchase_uom' => $data['purchase_uom'],
            'supp_pack_size' => $data['supp_pack_size'],
            'permanent_disc_pct' => $data['permanent_disc_pct'],
        ];

        // Use updateOrCreate with proper conditions
        return $this->model->updateOrCreate(
            $whereClause,
            array_merge($data, $updateData, ['ordhead_id' => $ordheadId])
        );
    }

    /**
     * Determine the primary key of the ordhead table
     */
    protected function getOrdheadPrimaryKey(): string
    {
        // Check if ordhead table has ordid column
        $ordheadTable = (new OrdHead())->getTable();
        return Schema::hasColumn($ordheadTable, 'ordid') ? 'ordid' : 'id';
    }
}