<?php

namespace App\Repositories\OrdHead;

use LaravelEasyRepository\Repository;

interface OrdHeadRepository extends Repository{

    // Write something awesome :)
    public function where($column, $value);
    public function updateOrCreate($data);
}
