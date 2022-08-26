<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class ActionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route()->parameter('action')->user_id !== auth()->user()->id) {
                abort(403, 'You do not have permission to do that.');
            }

            return $next($request);
        })->only(['destroy', 'archive']);
    }

    /**
     * Display a listing of the user's actions.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMe(Request $request)
    {
        return $this->generateIndex(true, $request);
    }

    /**
     * Display a listing of other's actions.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexOthers(Request $request)
    {
        return $this->generateIndex(false, $request);
    }

    /**
     * Get a list of actions for Inertia
     *
     * @return object
     */
    private function generateIndex($me, Request $request)
    {
        $paginatedActions = Action::query()
            ->where(
                'user_id',
                $me ? '=' : '<>',
                auth()->user()->id
            )
            ->when($request->input('search'), function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->when(! $request->input('archived'), function ($query) {
                $query->whereNull('archived_at');
            }, )
            ->when($request->input('category'), function ($query, $category_slug) {
                $categories = Category::all();
                $category_id = $categories->where('slug', $category_slug)->first()->id;
                $query->where('category_id', $category_id);
            })
            ->orderBy('archived_at', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(24)
            ->withQueryString()
            ->through(
                fn ($action) => $this->getActionForView($action)
            );

        return Inertia::render('List', [
            'title' => $me ? 'My Actions' : 'Actions by others',
            'me' => $me,
            'categories' => Category::all(),
            'actions' => $paginatedActions,
            'filters' => $request->only(['search', 'category', 'archived']),
        ]);
    }

    /**
     * Optimized action-content for Inertia
     *
     * @param  Action  $action
     * @return array
     */
    private function getActionForView($action)
    {
        return [
            'id' => $action->id,
            'user' => [
                'id' => $action->author->id,
                'name' => $action->author->name,
            ],
            'archived_at' => $action->archived_at,
            'category_id' => $action->category->id,
            'description' => $action->description,
            'likes' => [
                'total' => $action->likes->count(),
                'liked' => $action->likes->where('user_id', auth()->user()->id)->count() > 0,
            ],
            'inspirations' => [
                'total' => $action->inspirations_descendants ? count($action->inspirations_descendants) : 0,
            ],
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Action $action)
    {
        $ancestor_ids = json_decode($action->inspirations_ancestors);
        $ancestors = [];
        if ($ancestor_ids) {
            $ancestors_from_database = Action::whereIn('id', $ancestor_ids)->get()->map(function ($action) {
                return  [
                    ...$this->getActionForView($action),
                    'created_at' => $action->created_at->format('Y-m-d'),
                ];
            });

            // Show deleted ancestors as well;
            $ancestors = collect($ancestor_ids)->map(function ($id) use ($ancestors_from_database) {
                if ($ancestors_from_database->where('id', $id)->count() > 0) {
                    return $ancestors_from_database->where('id', $id)->first();
                }

                return ['id' => $id];
            });
        }

        return Inertia::render('Action', [
            'categories' => Category::all(),
            'action' => [
                ...$this->getActionForView($action),
                'created_at' => $action->created_at->format('Y-m-d'),
                'ancestors' => $ancestors,
            ],
        ]);
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => 'required',
            'inspired_by' => 'nullable|exists:App\Models\Action,id',
            'category_id' => 'required|exists:App\Models\Category,id',
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
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Like the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Action  $action
     * @return \Illuminate\Http\Response
     */
    public function like(Action $action)
    {
        $liked = Like::where('user_id', auth()->user()->id)->where('action_id', $action->id);

        if ($liked->count() > 0) {
            $liked->delete();
        } else {
            Like::create([
                'user_id' => auth()->user()->id,
                'action_id' => $action->id,
            ]);
        }
    }

    /**
     * Archive the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Action  $action
     * @return \Illuminate\Http\Response
     */
    public function archive(Action $action)
    {
        $action->update([
            'archived_at' => $action->archived_at ? null : now(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
