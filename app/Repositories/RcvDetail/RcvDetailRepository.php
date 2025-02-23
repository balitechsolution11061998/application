<?php

namespace App\Repositories\RcvDetail;

use LaravelEasyRepository\Repository;

interface RcvDetailRepository extends Repository{

    // Write something awesome :)
    public function updateOrCreate(array $attributes, array $values = []);
}
