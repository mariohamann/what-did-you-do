<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class WelcomeData extends Data
{
    public function __construct(
        public bool $canLogin,
        public bool $canRegister,
        public string $laravelVersion,
        public string $phpVersion,
    ) {
    }
}
