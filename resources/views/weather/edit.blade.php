@extends('layouts.main')

@section('title', 'Add New Place')    

@section('content')
<main class="py-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-title">
            <strong>Add New Place</strong>
          </div>           
          <div class="card-body">
            <form action={{route('weather.update', $post->id)}} enctype="multipart/form-data" method="post">
              @csrf
              @method('put')
              @include('weather._form')
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection