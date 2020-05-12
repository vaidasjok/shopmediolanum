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


    <h2>Add New Brand</h2>

    <form action="/{{ App::getLocale() }}/admin/add-brand" method="post" name="add_brand" id="add_brand">

        {{csrf_field()}}

        <div class="form-group">
            <label for="coupon_code">Brand Name</label>
            <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Brand Name" required >
        </div>
        <div class="form-group">
            <label for="coupon_code">Brand Description</label>
            <textarea class="form-control" name="brand_description" id="brand_description" placeholder="Brand Description" required ></textarea>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

   <h2>Brands</h2>
    <form action="" method="post">
        {{ csrf_field() }}
        <table class="table table-striped table-bordered table-responsive" style="margin-top: 30px;">
            <thead>
                <tr>
                <th>Brand ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Language</th>
                <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)    
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->description }}</td>
                    <td>{{ App::getLocale() }}</td>
                    <td class="text-center">
                        <a href="{{ route('edit_brand', ['id' => $brand->id]) }}" class="btn btn-primary">Edit/Translate</a>
                        <a href="{{ route('delete_brand', ['id' => $brand->id]) }}" class="btn btn-danger delete-warning">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

</div>

@endsection