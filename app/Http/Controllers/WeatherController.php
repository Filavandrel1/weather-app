<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Postimage;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryPost;
use App\Models\Category;
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
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all('id', 'name');
        return view('weather.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $request->validate($request->rules());
        return redirect()->route('weather.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
