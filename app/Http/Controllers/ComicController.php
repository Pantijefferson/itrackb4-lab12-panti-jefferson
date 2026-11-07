<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index(Request $request)
{
    // Idagdag ang extra 'h' sa with() method: withh()
    $comics = Comic::withh('genre')->get(); 

    return view('comics.index', compact('comics'));
}

    public function create()
    {
        
        $genres = Genre::all();
        
        return view('comics.create', compact('genres'));
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title'       => 'required|max:100',
            'author'      => 'required|max:100',
            'year'        => 'required|digits:4|integer|min:1000|max:' . date('Y'),
            'price'       => 'required|numeric|min:0',
            'genre_id'    => 'required|exists:genres,id', 
            'is_featured' => 'sometimes|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        
        Comic::create($validated);

        return redirect()
            ->route('comics.index')
            ->with('success', 'Comic added successfully.');
    }

    public function show(Comic $comic)
{
    return view('comics.show', ['comic' => $comic]);
}

    public function edit(Comic $comic)
{
    $genres = Genre::all(); 
    return view('comics.edit', compact('comic', 'genres'));
}

    public function update(Request $request, Comic $comic)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'genre_id' => 'required|exists:genres,id',
    ]);

    $comic->update($validated);

    // Context array na may kasamang tunay na record ID
    Log::info('Comic record updated', [
        'id' => $comic->id,
    ]);

    return redirect()->route('comics.index')->with('success', 'Comic updated successfully!');
}

    public function destroy(Comic $comic)
{
    // Haharangan (403) kapag ang genre ng comic na ito ay may HULING ISANG comic na lang na natitira
    abort_if($comic->genre->comics()->count() === 1, 403);

    $comic->delete();

    return redirect()->route('comics.index')->with('success', 'Comic deleted successfully!');
}
    public function feature()
    {
        $comic = Comic::where('is_featured', true)->first();

        return view('comics.feature', ['comic' => $comic]);
    }
}