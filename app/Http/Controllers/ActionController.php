<?php

namespace App\Http\Controllers;

use App\Data\ActionData;
use App\Data\ActionIndexData;
use App\Data\CategoryData;
use App\Models\Action;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard', ActionIndexData::from([
            'categories' => CategoryData::collection(Category::all()),
            'actions' => ActionData::collection(Action::all()),
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
