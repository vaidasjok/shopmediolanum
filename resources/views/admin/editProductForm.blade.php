@extends('layouts.admin')

@section('body')


<div class="table-responsive">

    <form action="/admin/updateProduct/{{$product->id}}" method="post">
        <input type="hidden" name="type" value="{{$product->type}}">
        {{csrf_field()}}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" value="{{$product->name}}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="description" value="{{$product->description}}" required>
        </div>
<!-- 

        <div class="form-group">
             <label for="type">Type</label>
            <select class="form-control" name="type" id="type" required>
                @foreach(Config::get('settings.types') as $key => $type)
                <option value="{{ $key }}" @if(isset($product)) {{ ($product->type == $type) ? 'selected' : '' }} @endif>{{ $type }}</option>
                @endforeach
            </select>
        </div> -->

        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <?php echo $categories_dropdown; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="price" value="{{$product->price}}" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection