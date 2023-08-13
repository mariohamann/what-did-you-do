<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class ActionData extends Data
{
    public function __construct(
        public int $id,
        public UserData $user,
        public string $description,
        public string $created_at,
        public ActionLikesData $likes,
        public CategoryData $category,
        public float $lat,
        public float $lng,
    ) {
    }
}
