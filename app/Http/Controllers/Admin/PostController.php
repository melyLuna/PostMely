<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|unique:posts,slug',
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id'      => 'required|exists:users,id',
            'category_id'  => 'required|exists:categories,id',
            'tags'         => 'nullable|array|exists:tags,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('img_path')) {
            $validated['img_path'] = $request->file('img_path')->store('posts', 'public');
        } else {
            $validated['img_path'] = null;
        }

        $post = Post::create($validated);
        if ($request->tags) {
        $post->tags()->sync($request->tags); 
    }

        return redirect()->route('admin.posts.index')->with('info', 'Post creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'slug'         => 'required|string|unique:posts,slug,' . $post->id,
            'excerpt'      => 'required|string',
            'content'      => 'required|string',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id'      => 'required|exists:users,id',
            'category_id'  => 'required|exists:categories,id',
            'tags'         => 'nullable|array|exists:tags,id',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('img_path')) {
            if ($post->img_path) {
                Storage::disk('public')->delete($post->img_path);
            }
            $validated['img_path'] = $request->file('img_path')->store('posts', 'public');
        } else {
            unset($validated['img_path']);
        }

        $post->update($validated);
        if ($request->tags) {
            $post->tags()->sync($request->tags); // Adjuntar etiquetas
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post eliminado.');
    }
}
