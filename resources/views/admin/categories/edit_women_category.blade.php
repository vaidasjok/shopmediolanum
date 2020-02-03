@extends('layouts.admin')

@section('body')

<div class="table-responsive">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>

            <li>{!! print_r($errors->all()) !!}</li>

        </ul>
    </div>
    @endif


    <h2>Edit Category</h2>

    <form action="{{route('editWomenCategory', ['id' => $category->id])}}" id="edit_category" method="post" enctype="multipart/form-data">

        {{csrf_field()}}
		

        @include('admin.categories.fields')

        <button type="submit" name="submit" class="btn btn-primary">Edit Category</button>
    </form>

</div>

@endsection