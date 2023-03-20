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
      <a href="{{asset('storage/images/'. $post->images->first()->path .'/'.$image->image_name)}}">
        <img class="post_img  " src={{ asset('storage/images/'. $post->images->first()->path . '/'. $image->image_name)}} width="100%">
      </a>
      @endforeach
    </div>
    <div class="weather_section">
      <div class="weather_conditions">
        @if ($weather['error']== false) 
        <p style="text-align: center">Current weather for {{$post->city}}:</p>
        <div class="weather_parameters_wrapper">
          <p style="border-right: 2px solid rgba(0,0,0,0.09); padding: 20px 10px; width: 50%; margin-bottom: 0;">{{$weather['description']}}</p>
          <div style="width: 50%;">
            <img src="{{$weather['iconURL']}}" width="100%" alt="">
          </div>
        </div>
        <div class="temperature_wrapper">
          <p style="border-right: 2px solid rgba(0,0,0,0.09); padding: 20px 10px; width: 50%;">Temp: {{$weather['temp']}}°C</p>
          <p style="padding: 20px 10px; width: 50%;">Humidity: {{$weather['humidity']}}%</p>
        </div>
        @else
        <p>Weather for {{$post->city}} is not available</p>
        <p>Sorry for complication</p>
        <p>We working on it</p>
        @endif
      </div>
      <div class="price_wrapper">
        <p>Prices starts from:</p>
        <p>{{$post->price}}zł</p>
      </div>
    </div>
  </div>
  <div class="comment_section" style="margin-bottom: 10vh;">
    <hr>
    <h2 style="text-align: center">Comments</h2>
    <div class="comments_wrapper">
      @foreach ($post->comments as $comment)
      <div class="comment">
        <div class="comment_header">
          <span style="font-weight: 700; font-size: 14px;">{{$comment->user->name}}</span> <span style="color: rgba(0, 0, 0, 0.3); margin-left: 20px;"> {{$comment->created_at}} </span>
        </div>
        <p style="margin-bottom: 0px">{{$comment->content}}</p>
        @auth    
          @can ('delete', $comment)
          <form action="{{route('comment.destroy', $comment->id)}}" style="text-align: end" method="post">
            @csrf
            @method('delete')
            <button type="submit" style="width: 100px; height: 30px; padding: 0;"class="btn btn-outline-danger">Delete</button>
          </form> 
          @endcan
        @endauth
        <hr>
      </div>
      @endforeach
      <div class="adding_comment_wrapper">
        <form action="{{route('comment.store')}}" method="POST" class="adding_comment_form">
          @csrf
          <div style="display: flex; justify-content: center; align-items: center">
            <textarea name="content" id="content" required class="comment_content" cols="100" 
            placeholder="@guest You need to be logged in to add comment @endguest @auth Add comment...@endauth"></textarea>
            <input type="hidden" name="post_id" value="{{$post->id}}">
            <button style="height: 50%; margin-left: 30px;" @guest
              disabled
            @endguest class="btn btn-secondary">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection