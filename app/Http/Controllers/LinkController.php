<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Tag;
use App\Models\UserTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $links = $user->links()->with(['globalTags', 'userTags'])->latest()->get();
        return view('links.index', compact('links'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $globalTags = Tag::all();
        $userTags = $user->userTags()->get();

        return view('links.create', compact('globalTags', 'userTags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'tags' => 'nullable|array',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $link = $user->links()->create($request->only('title', 'url', 'image_url'));

        $globalTagIds = [];
        $userTagIds = [];

        foreach ($request->input('tags', []) as $tagInput) {
            if (str_starts_with($tagInput, 'global:')) {
                $tagId = (int) str_replace('global:', '', $tagInput);
                $globalTagIds[] = $tagId;
            } elseif (str_starts_with($tagInput, 'user:')) {
                $tagId = (int) str_replace('user:', '', $tagInput);
                $userTagIds[] = $tagId;
            } else {
                // New user tag string
                $tag = UserTag::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => trim($tagInput),
                ]);
                $userTagIds[] = $tag->id;
            }
        }

        // Attach tags via pivot
        $link->globalTags()->sync($globalTagIds);
        $link->userTags()->sync($userTagIds);

        return redirect()->route('links.index')->with('success', 'Link created successfully with tags!');
    }

    public function edit(Link $link)
    {
        $this->authorize('update', $link);
        $globalTags = Tag::all();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userTags = $user->userTags()->get();

        return view('links.edit', compact('link', 'globalTags', 'userTags'));
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

        $globalTagIds = [];
        $userTagIds = [];

        foreach ($request->input('tags', []) as $tagInput) {
            if (str_starts_with($tagInput, 'global:')) {
                $tagId = (int) str_replace('global:', '', $tagInput);
                $globalTagIds[] = $tagId;
            } elseif (str_starts_with($tagInput, 'user:')) {
                $tagId = (int) str_replace('user:', '', $tagInput);
                $userTagIds[] = $tagId;
            } else {
                $tag = UserTag::firstOrCreate([
                    'user_id' => $link->user_id,
                    'name' => trim($tagInput),
                ]);
                $userTagIds[] = $tag->id;
            }
        }

        $link->globalTags()->sync($globalTagIds);
        $link->userTags()->sync($userTagIds);

        return redirect()->route('links.index')->with('success', 'Link updated!');
    }

    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $link->delete();

        return redirect()->route('links.index')->with('success', 'Link deleted!');
    }
}
