<?php

namespace App\Http\Controllers;

use App\Models\Action;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Action $action)
    {
        $action->likes()->create([
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $action->likes()->where('user_id', auth()->user()->id)->delete();
    }
}
