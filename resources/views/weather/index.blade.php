@extends('layouts.main') @section('title', 'Weather App') @section('content')
<main>
  @if ($message = session('message'))
  <div class="alert alert-success">{{$message}}</div>
  @endif
  <div class="main-container">
    @include('weather._filter')
    <div class="posts-container">
      @foreach ($posts as $post)
      <div class="post">
        <div class="basic-info">
          <img src={{ asset('storage/images/'. str_replace(' ', '_', $post->place) .$post->id .'/'. $post->logo_image)}} alt="" class="place-img">
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
          <div>
            <a href="{{ route('weather.show', $post->id) }}" class="btn btn-sm btn-circle btn-outline-info"
              title="Show"><i class="fa fa-eye"></i></a>
              @auth
                  
              @if (Auth::user()->id == $post->user_id || Auth::user()->role == 'admin')
              <a href="{{route('weather.edit', $post->id)}}" class="btn btn-sm btn-circle btn-outline-secondary" title="Edit"><i
              class="fa fa-edit"></i></a>
              <form action="{{route('weather.destroy', $post->id)}}" onsubmit="return confirm('Are you sure?')" style="display:inline" method='post'>
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Delete"><i class="fa fa-times"></i></button>
              </form>
              @endauth
            @endif
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</main>
@endsection