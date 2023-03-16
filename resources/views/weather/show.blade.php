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
  <div class="comment_section" style="text-align: center">
  </div>
</main>
@endsection