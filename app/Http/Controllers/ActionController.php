<?php

namespace App\Http\Controllers;

use App\Data\ActionData;
use App\Data\ActionIndexData;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $map = $request->input('map', '');
        $category = $request->input('category', '');

        $actions = Action::query();

        if (Str::of($map)->isNotEmpty()) {
            [$neLng, $neLat, $swLng, $swLat] = explode(',', $map);
            $actions->locatedWithin($neLat, $neLng, $swLat, $swLng);
        }

        if (Str::of($category)->isNotEmpty()) {
            $actions->where('category_id', $category);
        }

        $actions = $actions->orderBy('id', 'desc')->cursorPaginate(10)->withQueryString();

        return Inertia::render('Actions/Index', ActionIndexData::from([
            'actions' => ActionData::collection($actions),
            'actions_json_url' => Action::getJsonFileUrl(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'inspired_by' => 'nullable|exists:App\Models\Action,id',
            'category_id' => 'required|exists:App\Models\Category,id',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        Action::create(['user_id' => auth()->user()->id, ...$attributes]);

        return to_route('index')->with('success', 'Action created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        // $action = Action::findOrFail($id);
        // $actionArray = $action->toArray();

        // Log the serialized model for debugging
        // \Log::info($actionArray);
        // return Inertia::render(
        //     'Actions/Show',
        //     ActionData::from($actionArray)
        // );

        // get collection with only the action
        $actions = Action::query()->where('id', $id)->cursorPaginate(1);

        return Inertia::render('Actions/Index', ActionIndexData::from([
            'actions' => ActionData::collection($actions),
            'actions_json_url' => Action::getJsonFileUrl(),
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Action $action)
    {
        $action->delete();
    }
}
