<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ActionLikesData extends Data
{
    public function __construct(
        public int $total,
        public bool $liked,
    ) {
    }
}
