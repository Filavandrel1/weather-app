<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Postimage;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryPost;
use App\Models\Category;

class WeatherController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all('id', 'name');
        $posts = Post::all();
        $images = Postimage::all();
        return view('weather.index', compact('posts', 'categories', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all('id', 'name');
        return view('weather.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place' => 'required|min:3|max:50|string',
            'country' => 'required|min:2|max:50|string',
            'description' => 'required',
            'price' => 'required|numeric',
            'images' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'categories' => 'required'
        ]);
        $post = Post::create([
            'place' => $request->place,
            'country' => $request->country,
            'description' => $request->description,
            'price' => $request->price,
            'logo_image' => $request->file('images.0')->getClientOriginalName()
        ]);

        // dd($request->file('images'));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = Postimage::create([
                    'image_name' => $imagefile->getClientOriginalName(),
                    'post_id' => $post->id
                ]);
                Storage::putFileAs('public/images', $imagefile, $post->place . $post->id . '/' . $image->image_name);
            };
        }
        if ($request->has('categories')) {
            foreach ($request->categories as $category) {
                $categoryPost = CategoryPost::create([
                    'category_id' => $category,
                    'post_id' => $post->id
                ]);
            }
        }

        // foreach ($request->file('images') as $imagefile) {
        //     $image = Postimage::create([
        //         'image_name' => $imagefile->getClientOriginalName(),
        //         'post_id' => $post->id
        //     ]);
        //     Storage::putFileAs('public/images', $imagefile, $image->image_name);
        // };
        // $image = Postimage::create([
        //     'image_name' => $request->file('image')->getClientOriginalName(),
        //     'post_id' => $post->id
        // ]);
        // Storage::putFileAs('public/images', $request->file('image'), $image->image_name);
        return redirect()->route('weather.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
