<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::orderBy('id', 'desc')->get();
        return view('admin.post.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|max:255",
            "description" => "required",
            "image" => "required",
            "categories" => "required",
          ]);

            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->meta_keywords = $request->meta_keywords;
            $post->meta_description = $request->meta_description;

            if ($request->hasFile('image')){
                $file = $request->image;
                $fileName = time().'.' . $file->getClientOriginalExtension();
                $file->move('images', $fileName);
                $post->image = "images/" . $fileName;
            }
            $post->save();
            $post->categories()->attach($request->categories);
            toast('Record saved successfully!','success');
            // return redirect()->back();
            return redirect()->route('post.index');
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
        $post = Post::find($id);
        $categories = Category::all();
        return view('admin.post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            "title" => "required|max:255",
            "description" => "required",
            "categories" => "required",
          ]);

            $post = Post::find($id);
            $post->title = $request->title;
            $post->description = $request->description;
            $post->meta_keywords = $request->meta_keywords;
            $post->meta_description = $request->meta_description;
            $post->status = $request->status;

            if ($request->hasFile('image')){
                $file = $request->image;
                $fileName = time().'.' . $file->getClientOriginalExtension();
                $file->move('images', $fileName);
                $post->image = "images/" . $fileName;
            }
            $post->update();
            $post->categories()->sync($request->categories);
            toast('Record updated successfully!','success');
            return redirect()->back();
            // return redirect()->route('post.edit', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        unlink(public_path($post->image));
        $post->delete();
        toast('Record deleted successfully!','success');
        return redirect()->back();
    }
}
