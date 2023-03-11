@extends('layouts.main') @section('title', 'Weather App') @section('content')
<main>
  <div class="main-container">
    <div class="search-container">
      <div class="categories">
        @foreach ($categories as $category)
        <div>
          <input type="checkbox" name="categories[]" id={{"categories".$category->id}} value={{$category->id}}>
          <label for={{"categories".$category->id}}>{{$category->name}}</label>
        </div>
        @endforeach
      </div>
      <input type="text" class="form-control search-btn" name="search" value="" id="search-input" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2" />
    </div>
    <div class="posts-container">
      @foreach ($posts as $post)
      <div class="post">
        <div class="basic-info">
          <img src={{ asset('storage/images/'. $post->place .$post->id .'/'. $post->logo_image)}} alt="" class="place-img">
          <p class="place-name">{{$post->place}}</p>
        </div>
        <p>{{$post->country}}</p>
        <p><strong> Cena: </strong> {{$post->price}} zł</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <a href="{{ route('weather.show', $post['id']) }}" class="btn btn-secondary">Show</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</main>
@endsection