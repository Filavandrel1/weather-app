@if (!$post->exists) 
  <div class="input-group">
    <div class="custom-file">
      <input type="file" multiple name="images[]" value="{{old('images', $post->images)}}" class="custom-file-input @error('images') is-invalid @enderror" id="images">
      <label class="custom-file-label" for="images">@if (count($errors) > 0)
        <span style="color: red">{{ $errors->first('images') }} {{$errors->first('images.*')}}</span>
        @else
        Choose images 
        @endif</label>
    </div>
  </div>
  <span style="font-size: 10px;">Pierwsze zdjęcie powinno być w wymiarze 200 * 200, będzie ono zdjęciem tytułowym, dopuszczalne formaty: jpeg,png,jpg,gif,svg.</span>
@else
  <div class="all_image_contener">
    @foreach ($post->images as $image)
      <div>
        <img width="100%" height="150px" src="{{asset('storage/images/'. $post->place .$post->id .'/'.$image->image_name)}}" alt="">
        <button>Select main</button>
        <button>delete</button>
      </div>
        @endforeach
  </div>
@endif