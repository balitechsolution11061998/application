<?php

namespace App\Repositories\OrdSku;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdSku;

class OrdSkuRepositoryImplement extends Eloquent implements OrdSkuRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected OrdSku $model;

    public function __construct(OrdSku $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function updateOrCreate($data)
    {
        // Check if the record already exists
        $existingRecord = $this->model->where([
            'ordhead_id' => $data['ordhead_id'],
            'sku' => $data['sku'],
            'order_no' => $data['order_no'],
            'upc' => $data['upc'],
        ])->first();

        if ($existingRecord) {
            // Update the existing record
            return $existingRecord->update([
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
            ]);
        } else {
            // Create a new record
            return $this->model->create(array_merge($data, [
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
            ]));
        }
    }

}
