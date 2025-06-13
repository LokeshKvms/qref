<?php
// app/Http/Controllers/LinkController.php
namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        $links = Auth::user()->links()->latest()->get();
        return view('links.index', compact('links'));
    }

    public function create()
    {
        return view('links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'tags' => 'nullable|array',
        ]);

        $link = Auth::user()->links()->create($request->only('title', 'url', 'image_url'));

        $tagIds = [];

        foreach ($request->input('tags', []) as $tagInput) {
            // Handle both numeric IDs and new tag strings
            if (is_numeric($tagInput)) {
                $tagIds[] = (int) $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput)]);
                $tagIds[] = $tag->id;
            }
        }

        $link->tags()->sync($tagIds);

        return redirect()->route('links.index')->with('success', 'Link created successfully with tags!');
    }

    public function edit(Link $link)
    {
        $this->authorize('update', $link);
        return view('links.edit', compact('link'));
    }

    public function update(Request $request, Link $link)
    {
        $this->authorize('update', $link);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'tags' => 'nullable|array',
        ]);

        $link->update($request->only('title', 'url', 'image_url'));

        // Process tags
        $tagIds = [];
        foreach ($request->input('tags', []) as $tagInput) {
            if (is_numeric($tagInput)) {
                $tagIds[] = (int) $tagInput;
            } else {
                $tag = Tag::firstOrCreate(['name' => trim($tagInput)]);
                $tagIds[] = $tag->id;
            }
        }

        $link->tags()->sync($tagIds);

        return redirect()->route('links.index')->with('success', 'Link updated!');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted!');
    }
}
