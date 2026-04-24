<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Manga::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'title' => ['required', 'string', 'unique:mangas,title'],
            'description' => ['nullable', 'text'],
            'author_id' => ['required', 'exists:authors,id'],
            'genre_id' => ['required', 'exists:genres,id'],
        ]);

        $manga = Manga::create($validated);
        return response()->json($manga, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Manga $manga)
    {
        return $manga->load(['author', 'genres']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        $validated = request()->validate([
            'title' => ['sometimes', 'required', 'string', Rule::unique('mangas', 'title')->ignore($manga->id)],
            'description' => ['nullable', 'text'],
            'author_id' => ['sometimes', 'required', 'exists:authors,id'],
            'genre_id' => ['sometimes', 'required', 'exists:genres,id'],
        ]);

        $manga->update($validated);

        return $manga->load(['author', 'genres']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manga $manga)
    {
        $manga->delete();

        return response()->json(null, 204);
    }
}
