<div class="row">
  <div class="col-md-12">
    <div class="form-group row">
      <label for="place" class="col-md-3 col-form-label">Place name</label>
      <div class="col-md-9">
        <input type="text" name="place" id="place" value="" class="form-control @error('place') is-invalid @enderror">
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
        <input type="text" name="country" id="country" value="" class="form-control @error('country') is-invalid @enderror">
        @error('country')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    <div class="form-group row">
      <label for="description" class="col-md-3 col-form-label">Description</label>
      <div class="col-md-9">
        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"></textarea>
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
        <input type="number" min="0" name="price" id="price" value="" class="form-control @error('price') is-invalid @enderror">
        @error('price')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>
    <div class="input-group">
      <div class="custom-file">
        <input type="file" multiple name="images[]" class="custom-file-input @error('images') is-invalid @enderror" id="images">
        <label class="custom-file-label" for="images">@if (count($errors) > 0)
          {{ $errors->first('images') }} {{$errors->first('images.*')}}
          @else
          Wybierz zdjęcia
          @endif</label>
      </div>
    </div>
    <span style="font-size: 10px;">Rozmiary zdjęć powinny być w wymiarze 200 * 200, dopuszczalne formaty: jpeg,png,jpg,gif,svg.</span>
    <hr>
    <p style="text-align: center">Categories</p>
    <div class="categories_to_choose">
      @foreach ($categories as $category)
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="categories[]" id="{{$category->name}}" value="{{$category->id}}" aria-label="Checkbox for following text input">
          </div>
        </div>
        <label for="{{$category->name}}" class="form-control">{{$category->name}}</label>
      </div>
      @endforeach
    </div>
    <hr>
    <div class="form-group row mb-0">
      <div class="col-md-20 offset-md-5">
          <button type="submit" class="btn btn-primary">Create</button>
          <a href="{{route('weather.index')}}" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </div>
  </div>
</div>