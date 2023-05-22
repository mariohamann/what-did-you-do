<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ActionsJsonData extends Data
{
    public function __construct(
        public int $id,
        public int $ca,
        public float $la,
        public float $ln,
    ) {
    }
}
