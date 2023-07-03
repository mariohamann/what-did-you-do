<?php

namespace App\Http\Controllers;

use App\Data\ActionData;
use App\Models\Action;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Action $action)
    {
        if ($action->likes()->where('user_id', auth()->user()->id)->exists()) {
            return;
        }
        $action->likes()->create([
            'user_id' => auth()->user()->id,
        ]);

        $actions = Action::where('id', $action->id)->get();

        return Redirect::back()
            ->with('updated', ['actions' => ActionData::collection($actions)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $action->likes()->where('user_id', auth()->user()->id)->delete();

        // query the liked action
        $actions = Action::where('id', $action->id)->get();

        return Redirect::back()
            ->with('updated', ['actions' => ActionData::collection($actions)]);
    }
}
