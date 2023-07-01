<?php

namespace App\Http\Controllers;

use App\Data\ActionData;
use App\Data\ActionIndexData;
use App\Models\Action;
use Faker\Generator as Faker;
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
        $cursor = $request->input('cursor', '');

        $actions = Action::query();

        if (Str::of($map)->isNotEmpty()) {
            [$neLng, $neLat, $swLng, $swLat] = explode(',', $map);
            $actions->locatedWithin($neLat, $neLng, $swLat, $swLng);
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
    public function store(Request $request, Faker $faker)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'inspired_by' => 'nullable|exists:App\Models\Action,id',
            'category_id' => 'required|exists:App\Models\Category,id',
            // 'lat' => 'required|numeric',
            // 'lng' => 'required|numeric',
        ]);

        $ancestor_ids = null;

        if ($request->input('inspired_by')) {
            $inspired_by_input = $request->input('inspired_by');
            $inspired_by = Action::find($inspired_by_input);

            // Get all ancestors by adding the parent to the parent's ancestors
            $ancestor_ids = json_decode($inspired_by->inspirations_ancestors);
            $ancestor_ids[] = $inspired_by_input;
        }

        $new_action = Action::create([
            'user_id' => auth()->user()->id,
            'inspirations_ancestors' => json_encode($ancestor_ids),
            'lat' => $faker->latitude,
            'lng' => $faker->longitude,
            ...$attributes,
        ]);

        if ($request->input('inspired_by')) {
            $ancestors = Action::whereIn('id', $ancestor_ids)->get();

            // Go through every ancestor action and add the newly created item to the list of descendants
            foreach ($ancestors as $ancestor) {
                // Save to all descendants
                $descendants = $ancestor->inspirations_descendants;
                $descendants[] = $new_action->id;

                // Save to direct children
                $children = $ancestor->inspirations_children;
                $children[] = $new_action->id;

                $ancestor->update([
                    'inspirations_descendants' => $descendants,
                    'inspirations_children' => $children,
                ]);
            }
        }

        return to_route('action.show', $new_action->id)->with('success', 'Action created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $action = Action::findOrFail($id);
        $actionArray = $action->toArray();

        // Log the serialized model for debugging
        // \Log::info($actionArray);
        return Inertia::render(
            'Actions/Show',
            ActionData::from($actionArray)
        );
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
        $ancestors_ids = json_decode($action->inspirations_ancestors);
        if ($ancestors_ids) {
            $ancestors = Action::whereIn('id', $ancestors_ids)->get();
            // Go through every ancestor action and remove this item from the list of descendants
            foreach ($ancestors as $ancestor) {
                // Remove from descendants
                $descendants = $ancestor->inspirations_descendants;
                $descendants = Arr::where($descendants, fn ($value) => $value !== $action->id);

                // Remove from direct children
                $children = $ancestor->inspirations_children;
                $children = Arr::where($children, fn ($value) => $value !== $action->id);

                $ancestor->update([
                    'inspirations_descendants' => $descendants,
                    'inspirations_children' => $children,
                ]);
            }
        }

        $action->delete();
    }
}
