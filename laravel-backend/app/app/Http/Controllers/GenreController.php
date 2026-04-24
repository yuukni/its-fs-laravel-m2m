<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Genre::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'text'],
        ]);

        $genre = Genre::create($validated);
        return response()->json($genre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return $genre->load('mangas');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = request()->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'text'],
        ]);

        $genre->update($validated);

        return $genre->load('mangas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return response()->json(null, 204);
    }
}
