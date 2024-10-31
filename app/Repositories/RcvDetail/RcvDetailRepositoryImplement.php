<?php

namespace App\Repositories\RcvDetail;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RcvDetail;

class RcvDetailRepositoryImplement extends Eloquent implements RcvDetailRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected RcvDetail $model;

    public function __construct(RcvDetail $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }
}
