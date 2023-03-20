<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Postimage;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryPost;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Termwind\Components\Dd;

class WeatherController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all('id', 'name');
        $posts = Post::where(function ($query) {
            if ($search = request()->query('search')) {
                $query->where('place', 'LIKE', "%$search%");
            }
            if ($search2 = request()->query('user_posts')) {
                $query->where('user_id', 'LIKE', auth()->id());
            }
        })->where(function ($query) {
            $chosenCategories = request()->input('categories', []);
            $query->whereHas('categories', function ($subquery) use ($chosenCategories) {
                $subquery->whereIn('category_id', $chosenCategories);
            }, '=', count($chosenCategories));
        })->get();
        $images = Postimage::all();
        return view('weather.index', compact('posts', 'categories', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('weather.index')->with('message', 'Log in to create a post!');
        }
        $categories = Category::all('id', 'name');
        return view('weather.create', compact('categories'))->with('post', new Post());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request->validate($request->rules());
        $post = Post::create([
            'place' => $request->place,
            'country' => $request->country,
            'city' => $request->city,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => auth()->user()->id,
            'logo_image' => $request->file('images.0')->getClientOriginalName()
        ]);

        // dd($request->file('images'));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = Postimage::create([
                    'image_name' => $imagefile->getClientOriginalName(),
                    'post_id' => $post->id,
                    'path' => str_replace(' ', '_', $post->place) . $post->id
                ]);
                Storage::putFileAs('public/images', $imagefile, $image->path . '/' . $image->image_name);
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
        return redirect()->route('weather.index')->with('message', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $api_key = env('API_KEY');
        $post = Post::findOrFail($id);
        $images = Postimage::where('post_id', $id)->get('image_name');
        try {
            $response = Http::get(
                'https://api.openweathermap.org/data/2.5/weather',
                [
                    'q' => $post->city,
                    'appid' => $api_key
                ]
            )->json();
            $weather = [
                'description' => $response['weather'][0]['description'],
                'iconURL' => 'http://openweathermap.org/img/wn/' . $response['weather'][0]['icon'] . '.png',
                'temp' => $response['main']['temp'] - 273.15,
                'humidity' => $response['main']['humidity'],
                'error' => false
            ];
        } catch (\Throwable $th) {
            $weather = [
                'error' => true
            ];
        }
        return view('weather.show', compact('post', 'id', 'images', 'weather'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        $categories = Category::all('id', 'name');
        return view('weather.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $request->validate([
            'place' => 'required|min:3|max:50|string',
            'country' => 'required|min:2|max:50|string',
            'city' => 'required|min:2|max:50|string',
            'description' => 'required',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'categories' => 'array|min:1|required'
        ]);

        $post->update([
            'place' => $request->place,
            'country' => $request->country,
            'city' => $request->city,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // dd($request->file('images'));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = Postimage::create([
                    'image_name' => $imagefile->getClientOriginalName(),
                    'post_id' => $post->id,
                    'path' => $post->images->first()->path
                ]);
                Storage::putFileAs('public/images', $imagefile, $post->images->first()->path . '/' . $image->image_name);
            };
        }
        if ($request->has('categories')) {
            $categories = CategoryPost::where('post_id', $post->id)->get();
            foreach ($categories as $category) {
                $category->delete();
            }
            foreach ($request->categories as $category) {
                $categoryPost = CategoryPost::create([
                    'category_id' => $category,
                    'post_id' => $post->id
                ]);
            }
        }
        return redirect()->route('weather.index')->with('message', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        Storage::deleteDirectory('public/images/' . $post->images->first()->path);
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('weather.index')->with('message', 'Post deleted successfully!');
    }
}
