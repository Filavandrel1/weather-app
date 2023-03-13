@extends('layouts.main') @section('title', ) @section('content')
<main>
  
  <div class="post_wrapper">
    <div class="information_section">
      <h1>
        {{$post->place}}
      </h1>
      <p style="text-align: center">
        Country: {{$post->country}}
        <br>
        City: {{$post->city}}
      </p>
      <div>
        <p style="text-align: center; margin-bottom:0px;">
          Description:
        </p>
        <div class="post_description" style="padding: 50px; text-align: center; border: 2px solid rgba(0,0,0,0.09);">
          {{$post->description}}
        </div>
      </div>
      <div style="text-align: center">
        <p style="margin-bottom:0px;">
          Categories:
        </p>
        @foreach ($post->categories as $post_category)
          {{$post_category->name}}@if (!$loop->last), @endif
        @endforeach
      </div>
    </div>
    <div class="image_section">
      @foreach ($images as $image)
      <a href="{{asset('storage/images/'. $post->place .$post->id .'/'.$image->image_name)}}">
        <img class="post_img  " src="{{asset('storage/images/'. $post->place .$post->id .'/'.$image->image_name)}}" width="100%">
      </a>
      @endforeach
    </div>
    <div class="weather_section">
      Tu będzie API pogodowe
    </div>
  </div>
  <div class="comment_section" style="text-align: center">
    Tu będą komentarze
  </div>
</main>
@endsection