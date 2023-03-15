<div class="row">
  <div class="col-md-12">
    <div class="form-group row">
      <label for="place" class="col-md-3 col-form-label">Place name</label>
      <div class="col-md-9">
        <input type="text" name="place" id="place" value="{{old('place', $post->place)}}" class="form-control @error('place') is-invalid @enderror">
        @error('place')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label for="country" class="col-md-3 col-form-label">Country</label>
      <div class="col-md-9">
        <input type="text" name="country" id="country" value="{{old('country', $post->country)}}" class="form-control @error('country') is-invalid @enderror">
        @error('country')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label for="city" class="col-md-3 col-form-label">City</label>
      <div class="col-md-9">
        <input type="text" name="city" id="city" value="{{old('city', $post->city)}}" class="form-control @error('city') is-invalid @enderror">
        @error('city')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label for="description" class="col-md-3 col-form-label">Description</label>
      <div class="col-md-9">
        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{old('description', $post->description)}}</textarea>
        @error('description')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    {{-- <input type="hidden" name="user_id" id="user_id" value="1"> --}}
    <div class="form-group row">
      <label for="price" class="col-md-3 col-form-label">Price</label>
      <div class="col-md-9">
        <input type="number" min="0" name="price" id="price" value="{{old('price', $post->price)}}" class="form-control @error('price') is-invalid @enderror">
        @error('price')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    @include('weather._image-form')
    <hr>
    <p style="text-align: center">Categories</p>
    <div class="categories_to_choose">
      @foreach ($categories as $category)
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="categories[]" 
              @foreach (old('categories', $post->categories->pluck('id')->toArray()) as $choosed_category)
                  @if ($choosed_category == $category->id)
                    checked
                  @endif  
              @endforeach
           id="{{$category->name}}" value="{{$category->id}}" aria-label="Checkbox for following text input">
          </div>
        </div>
        <label for="{{$category->name}}" class="form-control">{{$category->name}}</label>
      </div>
      @endforeach
    </div>
    @if (count($errors) > 0)
      <span style="color: red">{{ $errors->first('categories') }}</span>
    @endif
    <hr>
    <div class="form-group row mb-0">
      <div class="col-md-20 offset-md-5">
          <button type="submit" class="btn btn-primary">{{$post->exists ? 'Update' : 'Save'}}</button>
          <a href="{{route('weather.index')}}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </div>
  </div>
</div>