<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Category;

class Doing extends Model
{
    use HasFactory;

    /**
     * Get the owner of the doing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(\Laravel\Jetstream\Jetstream::userModel(), 'user_id');
    }

    /**
     * Get the category of the doing. This is hard coded with Sushi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get original doing from which this doing was forked.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function original()
    {
        return $this->belongsTo($this, 'doing_id');
    }
}
