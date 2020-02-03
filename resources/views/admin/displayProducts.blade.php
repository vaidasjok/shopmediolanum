@extends('layouts.admin')

@section('body')

@include('alert')

<div class="table-responsive">
    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th>#id</th>
            <th>Image</th>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Price</th>
            <th>Edit Image</th>
            <th></th>
            <th>Actions</th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach($products as $product)
        <tr>
            <td>{{$product['id']}}</td>
            <td><img src="{{asset ('storage')}}/product_images/{{$product['image']}}" alt="{{asset ('storage')}}/product_images/{{$product['image']}}" width="100" height="100" style="max-height:220px" ></td>
           <!-- <td>  <img src="{{ Storage::url('product_images/'.$product['image'])}}"
                       alt="<?php echo Storage::url($product['image']); ?>" width="100" height="100" style="max-height:220px" >   </td> -->
            <td>{{$product['name']}}</td>
            <td>{{$product['description']}}</td>
            <td>{{$product['type']}}</td>
            <td>{{$product['price']}}</td>
            
            <td><a href="{{ route('addAttributes',['id' => $product['id'] ])}}" class="btn btn-primary">Add/Edit Attr</a></td>
            <td><a href="{{ route('adminEditProductImageForm',['id' => $product['id'] ])}}" class="btn btn-primary" title="Edit Main Image">Edit Main Image</a></td>
            <td><a href="{{ route('addProductImagesForm',['id' => $product['id'] ])}}" class="btn btn-info btn-mini" title="Add Additional Images">Add Images</a></td>
            <td><a href="{{ route('adminEditProductForm',['id' => $product['id'] ])}}" class="btn btn-primary">Edit</a></td>
            <td><a href="{{route('adminDeleteProduct', ['id' => $product['id']])}}"  class="btn btn-danger delete-warning">Delete</a></td>


        </tr>

        @endforeach





        </tbody>
    </table>
    {{$products->links()}}
    

</div>
@endsection