<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Sushi\Sushi;

    protected $visible = ['id', 'slug', 'name', 'emoji'];

    protected $rows = [
        [
            'id' => 1,
            'slug' => 'engagement',
            'name' => 'Engagement',
            'emoji' => '💪🏻',
        ],
        [
            'id' => 2,
            'slug' => 'energy',
            'name' => 'Energy',
            'emoji' => '⚡',
        ],
        [
            'id' => 3,
            'slug' => 'consumption',
            'name' => 'Consumption',
            'emoji' => '🛒',
        ],
        [
            'id' => 4,
            'slug' => 'food',
            'name' => 'Food',
            'emoji' => '🥗',
        ],
        [
            'id' => 5,
            'slug' => 'mobility',
            'name' => 'Mobility',
            'emoji' => '🚗',
        ],
    ];
}
