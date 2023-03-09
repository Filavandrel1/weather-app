@extends('layouts.main') @section('title', 'Weather App') @section('content')
<main>
  <div class="main-container">
    <div class="search-container">
      <div class="categories">
        <div>
          <input type="checkbox" name="" id="c1">
          <label for="c1">Categorie 1</label>
        </div>
        <div>
          <input type="checkbox" name="" id="c2">
          <label for="c2">Categorie 2</label>
        </div>
        <div>
          <input type="checkbox" name="" id="c3">
          <label for="c3">Categorie 3</label>
        </div>
        <div>
          <input type="checkbox" name="" id="c4">
          <label for="c4">Categorie 4</label>
        </div>
      </div>
      <input type="text" class="form-control search-btn" name="search" value="" id="search-input" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2" />
    </div>
    <div class="posts-container">
      <div class="post">
        <div class="basic-info">
          <img src="" alt="" class="place-img">
          <p class="place-name">random1</p>
        </div>
        <p>random2</p>
        <p><strong> Cena: </strong> random3</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <button type="submit" class="btn btn-secondary">Show</button>
        </div>
      </div>
      <div class="post">
        <div class="basic-info">
          <img src="" alt="" class="place-img">
          <p class="place-name">random1</p>
        </div>
        <p>random2</p>
        <p><strong> Cena: </strong> random3</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <button type="submit" class="btn btn-secondary">Show</button>
        </div>
      </div>
      <div class="post">
        <div class="basic-info">
          <img src="" alt="" class="place-img">
          <p class="place-name">random1</p>
        </div>
        <p>random2</p>
        <p><strong> Cena: </strong> random3</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <button type="submit" class="btn btn-secondary">Show</button>
        </div>
      </div>
      <div class="post">
        <div class="basic-info">
          <img src="" alt="" class="place-img">
          <p class="place-name">random1</p>
        </div>
        <p>random2</p>
        <p><strong> Cena: </strong> random3</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <button type="submit" class="btn btn-secondary">Show</button>
        </div>
      </div>
      <div class="post">
        <div class="basic-info">
          <img src="" alt="" class="place-img">
          <p class="place-name">random1</p>
        </div>
        <p>random2</p>
        <p><strong> Cena: </strong> random3</p>
        <div class="ending-info">
          <p class="added-by">random4</p>
          <button type="submit" class="btn btn-secondary">Show</button>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection