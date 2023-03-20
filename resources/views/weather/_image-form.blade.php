<script src="https://kit.fontawesome.com/fb8845726a.js" crossorigin="anonymous"></script>
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
  <div class="all_image_contener">
    @foreach ($post->images as $image)
      <div style="position: relative">
        <img width="100%" height="150px" src="{{asset('storage/images/'. $post->images->first()->path .'/'.$image->image_name)}}" alt="">
        @if ($image->image_name != $post->logo_image)
        <div style="position: absolute; top: 0; right: 0; background-color: #fff;">
          <form action=""></form>
          <form action="{{route('image.destroy', $image->id)}}" onsubmit="return confirm('Are you sure?')" style="display:inline" method='post'>
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Delete"><i class="fa fa-times"></i></button>
          </form>
          <form action={{route('image.update', $image->id)}} method="post">
            @csrf
            @method('put')
            <input type="hidden" value="{{$image->image_name}}" name="logo_image">
            <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Make logo"><i class="fa-solid fa-star"></i></button>
          </form>
        </div>
        @endif
      </div>
        @endforeach
  </div>