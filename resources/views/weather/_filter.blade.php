<script>
  function uncheckCheckboxes() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
        checkboxes[i].checked = false;
      }
    }
  }
</script>

<form method="get">
  <div class="search-container">
    <div class="categories">
      @foreach ($categories as $category)
      <div>
        <input type="checkbox" name="categories[]" id={{"categories".$category->id}} @if ($categories = request()->input('categories'))
        @foreach ($categories as $current_category)
        @if ($current_category == $category->id)
        checked
        @endif
        @endforeach
        @endif value={{$category->id}}>
        <label for={{"categories".$category->id}}>{{$category->name}}</label>
      </div>
      @endforeach
    </div>
    <div class="input-group search-btn">
      <input type="text" class="form-control " name="search" value="{{request()->query('search')}}" id="search-input" placeholder="Search..." aria-label="Search..." aria-describedby="button-addon2" />
      <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('search-input').value = '', uncheckCheckboxes(), this.form.submit()"
              @disabled(!request()->filled('search') and !request()->filled('categories'))
              >
              <i class="fa fa-refresh"></i>
            </button>
      <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
        <i class="fa fa-search"></i>
      </button> 
    </div>
  </div>
</form>