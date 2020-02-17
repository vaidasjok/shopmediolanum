@extends('layouts.admin')

@section('body')


<div class="table-responsive">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('alert')


    <h2>Add Front Page Images</h2>
    <form action="/admin/frontend-images" method="post" class=""  enctype="multipart/form-data">
        {{csrf_field()}}
		<div class="field_wrapper col-xs-12">
			<div class="row" style="margin-bottom: 10px;">
		        <div class="form-group">
	            	<label for="image">Image</label>
		            <input class="form-control-file" type="file" class=""  name="image" id="image" required>
		        </div>
		        <!-- <a href="javascript:void(0);" class="col-sm-2 btn btn-info add_button">Add Image</a> -->
		        <div class="form-group">
	            	<label for="title">Title</label>
		            <input class="form-control" type="text" name='title' id='title' placeholder="Tile" >
		        </div>
		        <div class="form-group">
	            	<label for="link">Link</label>
		            <input class="form-control" type="text" name='link' id='link' placeholder="/some-link-example" >
		        </div>
		        <label for="type">Type</label> (Here first part is row, second - column of the page position)
		        <select class="form-control" name="type" id="type">
		        	@foreach(Config::get('settings.frontend_image_types') as $type_key => $type_value)
						<option value="{{$type_key}}">{{$type_value}}</option>
		        	@endforeach
		        </select>

			</div>
				
		</div>

        <button type="submit" name="submit" style="margin-top: 20px;" class="btn btn-primary">Save Image</button>
    </form>
	
   <h2>Added Images</h2>
	<form action="" method="post">
		{{ csrf_field() }}
	    <table class="table table-striped table-bordered table-responsive" style="margin-top: 30px;">
			<thead>
				<tr>
				<th>Image ID</th>
				<th>Type</th>
				<th>Image</th>
				<th>Link</th>
				<th>Status</th>
				<th>Enable/Disable</th>
				<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($images as $image)    
				<tr>
					<td>{{ $image->id }}</td>
					<td>{{ $image->type }}</td>
					<td><img src="{{ asset('storage/frontend_images/' . $image->image) }}" alt="" style="max-height: 100px;"></td>
					<td>{{ $image->link }}</td>
					<td>@if($image->enabled == 1) enabled @else disabled @endif</td>
					<td>
						<input rel="{{ $image->id }}" class="enable_image" type="checkbox" @if($image->enabled == 1) checked @endif value="1">
					</td>
					<td>
						<a rel="{{ $image->id }}" rel1="delete-image" href="javascript:void(0);" class="btn btn-danger deleteRecord">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>

</div>

<script>
	$(document).ready(function(){

	    $('.deleteRecord').click(function() {
	    	var id = $(this).attr('rel');
	    	var deleteFunction = $(this).attr('rel1');
	    	swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this data!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then (function(willDelete){
				if(willDelete) {
	    			window.location.href="/admin/" + deleteFunction + "/" + id;
				}
	    	});
	    });

	    $('.enable_image').click(function() {
	    	var id = $(this).attr('rel');
	    	var input_field = $(this);
	    	var enabled = input_field.is(":checked");
	    	if(enabled == true) {
	    		enabled = 1;
	    	} else {
	    		enabled = 0;
	    	}

	    	$.ajax({
	    		url: '/admin/enable-image/' + id,
	    		method: 'get',
	    		data: {enabled: enabled},
	    		success: function(data, status, xhr ) {
	    			
	    		},
	    		error: function(error, status, xhr) {
	    			alert('Error');
	    		}
	    	});
	    });

	});
</script>


@endsection