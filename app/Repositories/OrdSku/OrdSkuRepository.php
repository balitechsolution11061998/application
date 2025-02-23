<?php

namespace App\Repositories\OrdSku;

use LaravelEasyRepository\Repository;

interface OrdSkuRepository extends Repository{

    // Write something awesome :)
    public function updateOrCreate($data);
}
