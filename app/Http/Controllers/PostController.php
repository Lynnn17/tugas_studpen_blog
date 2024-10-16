<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'category')->get();
        $categories  = Category::all();
        return view('posts.index', compact('posts', 'categories'));
    }

    public function tampilBerita(){
        $posts = Post::with('user', 'category')->get();
        $categories  = Category::all();
        return view('welcome', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        $photoPath = null;
        if ($request->file('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }


        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'photo' => $photoPath
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',

            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);


        if ($request->file('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $post->photo = $photoPath;
        }


        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
