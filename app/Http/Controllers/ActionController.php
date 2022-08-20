<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Like;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if ($request->route()->parameter('action')->user_id !== auth()->user()->id) {
                abort(403, "You do not have permission to do that.");
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
     * @return Object
     */
    private function generateIndex($me, Request $request) {
        $paginatedActions = Action::query()
            ->where(
                "user_id",
                $me ? "=" : "<>",
                auth()->user()->id
            )
            ->when($request->input('search'), function ($query, $search) {
                $query->where("description", "like", "%{$search}%");
            })
            ->when(!$request->input('archived'), function ($query) {
                $query->whereNull("archived_at");
            }, )
            ->when($request->input('category'), function ($query, $category_slug) {
                $categories = Category::all();
                $category_id = $categories->where("slug", $category_slug)->first()->id;
                $query->where("category_id", $category_id);
            })
            ->orderBy('archived_at', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(24)
            ->withQueryString()
            ->through(
                fn ($action) => $this->getActionForView($action)
            );
        return Inertia::render("List", [
            "title" => $me ? "My Actions" : "Actions by others",
            "me" => $me,
            "categories" => Category::all(),
            "actions" => $paginatedActions,
            "filters" => $request->only(['search', 'category', 'archived']),
        ]);
    }

    /**
     * Optimized action-content for Inertia
     *
     * @param  Action $action
     * @return array
     */

    private function getActionForView($action) {
        return [
            "id" => $action->id,
            "user" => [
                "id" => $action->author->id,
                "name" => $action->author->name,
            ],
            "archived_at" => $action->archived_at,
            "category_id" => $action->category->id,
            "description" => $action->description,
            "likes" => [
                "total" => $action->likes->count(),
                "liked" => $action->likes->where("user_id", auth()->user()->id)->count() > 0,
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
        return Inertia::render("Action", [
            "categories" => Category::all(),
            "action" => [
                ...$this->getActionForView($action),
                "created_at" => $action->created_at->format("Y-m-d"),
            ]
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
            'category_id' => 'required|exists:App\Models\Category,id',
        ]);

        Action::create([
            "user_id" => auth()->user()->id,
            ...$attributes,
        ]);
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
        $liked = Like::where("user_id", auth()->user()->id)->where("action_id", $action->id);

        if($liked->count() > 0) {
            $liked->delete();
        }
        else{
            Like::create([
                "user_id" => auth()->user()->id,
                "action_id" => $action->id,
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
            "archived_at" => $action->archived_at ? null : now(),
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
        $action->delete();
    }
}
