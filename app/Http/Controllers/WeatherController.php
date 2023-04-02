<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Postimage;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryPost;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Termwind\Components\Dd;

class WeatherController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Category::all('id', 'name');
        $posts = Post::where(function ($query) {
            $query->when(request()->has('search'), static function (Builder $query) {
                $query->where('place', 'LIKE', '%' . request()->input('search') . '%');
            })->when(request()->has('user_posts'), static function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        })->where(function ($query) {
            $chosenCategories = request()->input('categories', []);
            $query->whereHas('categories', function ($subquery) use ($chosenCategories) {
                $subquery->whereIn('category_id', $chosenCategories);
            }, '=', count($chosenCategories));
        })->get();
        return view('weather.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse|View
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
    public function store(PostRequest $request): RedirectResponse
    {
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
        return redirect()->route('weather.index')->with('message', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): view
    {
        $api_key = config('app.api_key');
        try {
            $response = Http::get(
                'https://api.openweathermap.org/data/2.5/weather',
                [
                    'q' => $post->city,
                    'appid' => $api_key,
                    'units' => 'metric'
                ]
            )->json();
            $weather = [
                'description' => $response['weather'][0]['description'],
                'iconURL' => 'http://openweathermap.org/img/wn/' . $response['weather'][0]['icon'] . '.png',
                'temp' => $response['main']['temp'],
                'humidity' => $response['main']['humidity'],
                'error' => false
            ];
        } catch (\Throwable $th) {
            $weather = [
                'error' => true
            ];
        }
        return view('weather.show', compact('post', 'weather'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): view
    {
        $this->authorize('update', $post);
        $categories = Category::all('id', 'name');
        return view('weather.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $validated = $request->safe()->except('images', 'categories');
        $post->update($validated);

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
    public function destroy(Post $post): RedirectResponse
    {
        Storage::deleteDirectory('public/images/' . $post->images->first()->path);
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('weather.index')->with('message', 'Post deleted successfully!');
    }
}
