<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'description', 'inspirations_ancestors', 'inspirations_descendants', 'inspirations_children', 'latitude', 'longitude'];

    protected $visible = ['id', 'user', 'category_id', 'description', 'created_at', 'likes', 'category', 'descendants_count', 'ancestors', 'latitude', 'longitude'];

    protected $appends = ['likes', 'category', 'user', 'descendants_count', 'ancestors'];

    protected $casts = [
        'inspirations_ancestors' => 'array',
        'inspirations_descendants' => 'array',
        'inspirations_children' => 'array',
    ];

    /**
     * Get the owner of the action.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
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

    // get user

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getLikesAttribute()
    {
        $total = $this->likes()->count();
        $liked = $this->likes()->where('user_id', auth()->id())->exists();

        return compact('total', 'liked');
    }

    public function getCategoryAttribute()
    {
        return $this->category()->first();
    }

    public function getDescendantsCountAttribute()
    {
        return count($this->inspirations_descendants ?? []);
    }

    public function getAncestorsAttribute()
    {
        $ancestors = json_decode($this->inspirations_ancestors, true) ?? [];

        return $this->whereIn('id', $ancestors)->get();
    }
}
