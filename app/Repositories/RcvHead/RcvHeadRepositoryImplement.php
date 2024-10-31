<?php

namespace App\Repositories\RcvHead;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\RcvHead;

class RcvHeadRepositoryImplement extends Eloquent implements RcvHeadRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected RcvHead $model;

    public function __construct(RcvHead $model)
    {
        $this->model = $model;
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }
}
