<?php

namespace App\Repositories\RcvHead;

use LaravelEasyRepository\Repository;

interface RcvHeadRepository extends Repository{

    // Write something awesome :)
    public function updateOrCreate(array $attributes, array $values = []);
    public function findByReceiveNo(string $receiveNo);
}
