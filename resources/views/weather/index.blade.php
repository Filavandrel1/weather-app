@extends('layouts.main') @section('title', 'Weather App') @section('content')
<main>
  <div class="main-container">
    @include('weather._filter')
    <div class="posts-container">
      @foreach ($posts as $post)
      <div class="post">
        <div class="basic-info">
          <img src={{ asset('storage/images/'. $post->place .$post->id .'/'. $post->logo_image)}} alt="" class="place-img">
          <p class="place-name">{{$post->place}}</p>
        </div>
        <div>
          <p style="font-weight: 700;">Categories:</p>
          <p>@foreach ($post->categories as $post_category)
            {{$post_category->name}}@if (!$loop->last), @endif
            @endforeach</p>
          </div>
        <p><strong> Cena: </strong> {{$post->price}} zł</p>
        <div class="ending-info">
          <p class="added-by">{{$post->user->name}}</p>
          <a href="{{ route('weather.show', $post['id']) }}" class="btn btn-secondary">Show</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</main>
@endsection