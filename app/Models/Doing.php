<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'content']; //<---- Add this line

    protected $visible = ['user', 'category_id', 'content'];

    /**
     * Get the owner of the doing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
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
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
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
