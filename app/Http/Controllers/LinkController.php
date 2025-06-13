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
            'tags' => 'array',
            'new_tag' => 'nullable|string|max:255',
        ]);

        $link = Auth::user()->links()->create($request->only('title', 'url', 'image_url'));

        $tagIds = [];

        // Existing tags
        if ($request->has('tags')) {
            $tagIds = array_map('intval', $request->input('tags'));
        }

        // Handle new tag
        if ($request->filled('new_tag')) {
            $newTag = Tag::firstOrCreate(['name' => $request->input('new_tag')]);
            $tagIds[] = $newTag->id;
        }

        $link->tags()->sync($tagIds);

        return redirect()->route('links.index')->with('success', 'Link added with tags!');
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
        ]);

        $link->update($request->only('title', 'url', 'image_url'));

        return redirect()->route('links.index')->with('success', 'Link updated!');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted!');
    }
}
