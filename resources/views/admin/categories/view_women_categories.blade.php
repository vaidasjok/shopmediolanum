@extends('layouts.admin')

@section('body')
	
	<h1>Women Categories</h1>

	@include('alert')

	<table id="table_id" class="display table table-striped">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Parent Category</th>
            <th>Category URL</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent_id }}</td>
            <td>{{ $category->url }}</td>
            <td class="">@if((strtolower($category->name) != 'shoes') && (strtolower($category->name) != 'accessoiries')&& (strtolower($category->name) != 'clothing') && (strtolower($category->name) != 'perfumes'))<a href="{{ route('editWomenCategory', ['id' => $category->id]) }}" class="btn btn-primary">Update</a> <a href="{{ route('deleteWomenCategory', ['id' => $category->id]) }}" class="btn btn-danger delete-warning">Delete</a>@endif</td>
        </tr>
        @endforeach
    </tbody>
</table>


<script>
	$(document).ready( function () {
	    $('#table_id').DataTable({
	    	'paging': true,
	    	'pageLength': 10,
	    	'lengthChange': false,
	    });
	} );
</script>


@endsection