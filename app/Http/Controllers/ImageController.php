<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Postimage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = Postimage::create([
                    'image_name' => $imagefile->getClientOriginalName(),
                    'post_id' => $post->id
                ]);
                Storage::putFileAs('public/images', $imagefile, str_replace(' ', '_', $post->place) . $post->id . '/' . $image->image_name);
            };
        }
        return redirect()->back();
    }
    public function destroy(string $id)
    {
        $postimage = Postimage::findOrFail($id);
        Storage::delete('public/images/' . $postimage->path . '/' . $postimage->image_name);
        $postimage->delete();
        return redirect()->back();
    }

    public function update(Request $request, string $id)
    {
        $post = Postimage::findOrFail($id);
        $post->post->update([
            'logo_image' => $request->logo_image
        ]);
        return redirect()->back();
    }
}
