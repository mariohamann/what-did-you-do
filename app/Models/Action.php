<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'description'];

    protected $visible = ['user', 'category_id', 'description'];

    /**
     * Get the owner of the action.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Laravel\Jetstream\Jetstream::userModel(), 'user_id');
    }

    /**
     * Get the category of the action. This is hard coded with Sushi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * Get original action from which this action was forked.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function original()
    {
        return $this->belongsTo($this, 'action_id');
    }

    /**
     * Get the likes for the action.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
