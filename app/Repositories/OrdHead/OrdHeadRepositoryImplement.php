<?php

namespace App\Repositories\OrdHead;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdHead;

class OrdHeadRepositoryImplement extends Eloquent implements OrdHeadRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected OrdHead $model;

    public function __construct(OrdHead $model)
    {
        $this->model = $model;
    }

    public function where($column, $value)
    {
        return $this->model->where($column, $value);
    }

    public function updateOrCreate($data)
    {
        return $this->model->updateOrCreate(
            [
                'id' => $data['id'],
                'order_no' => $data['order_no'],
            ],
            [
                'ship_to' => $data['ship_to'],
                'supplier' => $data['supplier'],
                'terms' => $data['terms'],
                'status_ind' => $data['status_ind'],
                'written_date' => $data['written_date'],
                'not_before_date' => $data['not_before_date'],
                'not_after_date' => $data['not_after_date'],
                'approval_date' => $data['approval_date'],
                'approval_id' => $data['approval_id'],
                'cancelled_date' => $data['cancelled_date'],
                'canceled_id' => $data['canceled_id'],
                'cancelled_amt' => $data['cancelled_amt'],
                'total_cost' => $data['total_cost'],
                'total_retail' => $data['total_retail'],
                'outstand_cost' => $data['outstand_cost'],
                'total_discount' => $data['total_discount'],
                'comment_desc' => $data['comment_desc'],
                'estimated_delivery_date' => $data['estimated_delivery_date'],
                'buyer' => $data['buyer'],
                'status' => $data['status'],
            ]
        );
    }
}
