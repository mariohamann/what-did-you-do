<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ActionData extends Data
{
    public function __construct(
        public int $id,
        public UserData $user,
        public string $description,
        public string $created_at,
        public ActionLikesData $likes,
        public CategoryData $category,
        public int $descendants_count,
        /** @var ActionData[] */
        public DataCollection $ancestors,
        public float $lat,
        public float $lng,
    ) {
    }
}
