<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action_id'];

    /**
     * Get the category of the action. This is hard coded with Sushi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(\App\Models\Action::class, 'action_id');
    }

    /**
     * Get the owner of the action.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\Laravel\Jetstream\Jetstream::userModel(), 'user_id');
    }
}
