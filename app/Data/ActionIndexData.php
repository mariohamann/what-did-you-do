<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ActionIndexData extends Data
{
    public function __construct(
        /** @var ActionData[] */
        public \Spatie\LaravelData\DataCollection $actions,
    ) {
    }
}
