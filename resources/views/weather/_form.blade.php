<div class="row">
  <div class="col-md-12">
    <div class="form-group row">
      <label for="place" class="col-md-3 col-form-label">City name</label>
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
        <textarea name="description" id="address" rows="3" class="form-control"></textarea>
      </div>
    </div>
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
        <input type="file" multiple class="custom-file-input" id="inputGroupFile04">
        <label class="custom-file-label" for="inputGroupFile04">Wybierz zdjęcia</label>
      </div>
    </div>
    <div class="categories_to_choose">
      @foreach ($categories as $category)
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="categories" id="{{$category}}" value="{{$category}}" aria-label="Checkbox for following text input">
          </div>
        </div>
        <label for="{{$category}}" class="form-control">{{$category}}</label>
      </div>
      @endforeach
    </div>
    <hr>
    <div class="form-group row mb-0">
      <div class="col-md-20 offset-md-5">
          <button type="submit" class="btn btn-primary">Create</button>
          <a href="" class="btn btn-outline-secondary">Cancel</a>
      </div>
    </div>
  </div>
</div>