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
        return Manga::with(['authors', 'genres'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:mangas,title'],
            'description' => ['nullable', 'string'],
            'author_ids' => ['required', 'array'],
            'author_ids.*' => ['exists:authors,id'],
            'genre_ids' => ['required', 'array'],
            'genre_ids.*' => ['exists:genres,id'],
        ]);

        $manga = Manga::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
        ]);
        $manga->authors()->sync($validated['author_ids']);
        $manga->genres()->sync($validated['genre_ids']);
        return response()->json(
            $manga->load(['authors', 'genres']),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Manga $manga)
    {
        return $manga->load(['authors', 'genres']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manga $manga)
    {
        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('mangas', 'title')->ignore($manga->id)],
            'description' => ['nullable', 'string'],
            'author_ids' => ['sometimes', 'array'],
            'author_ids.*' => ['exists:authors,id'],
            'genre_ids' => ['sometimes', 'array'],
            'genre_ids.*' => ['exists:genres,id'],
        ]);

        $manga->update([
            'title' => $validated['title'] ?? $manga->title,
            'description' => $validated['description'] ?? $manga->description,
        ]);
        if (isset($validated['author_ids'])) {
            $manga->authors()->sync($validated['author_ids']);
        }

        if (isset($validated['genre_ids'])) {
            $manga->genres()->sync($validated['genre_ids']);
        }

        return $manga->load(['authors', 'genres']);
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
