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
}
