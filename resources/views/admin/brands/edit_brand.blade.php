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

    @include('alert')


    <h2>Edit  Brand</h2>

    <form action="/{{ App::getLocale() }}/admin/edit-brand/{{ $brand->id }}" method="post" name="add_brand" id="add_brand">

        {{csrf_field()}}

        <div class="form-group">
            <label for="coupon_code">Brand Name</label>
            <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Brand Name" value="{{ $brand->name }}" required >
        </div>
        <div class="form-group">
            <label for="coupon_code">Brand Description</label>
            <textarea class="form-control" name="brand_description" id="brand_description" placeholder="Brand Description" required >{{ $brand->description }}</textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>


</div>

@endsection