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


    <h2>Add Product Additional Images</h2>
     <h3>Product Name: {{ $product->name }} (id: {{ $product->id }})</h3>
    <form action="/admin/addProductImagesForm/{{$product->id}}" method="post" class=""  enctype="multipart/form-data">
		<input type="hidden" name="product_id" value="{{ $product->id }}">
        {{csrf_field()}}
		<div class="field_wrapper col-xs-12">
			<div class="row" style="margin-bottom: 10px;">
		        <div class="form-group">
	            	<label for="images[]">Image (You can choose several images at once - use "CTRL" key for that).</label>
		            <input class="form-control-file" type="file" class=""  name="images[]" id="images" multiple required>
		        </div>
		        <!-- <a href="javascript:void(0);" class="col-sm-2 btn btn-info add_button">Add Image</a> -->
			</div>
				
		</div>

        <button type="submit" name="submit" style="margin-top: 20px;" class="btn btn-primary">Save Images</button>
    </form>
	
   <h2>Product additional images</h2>
	<form action="/admin/edit-attributes/{{ $product->id }}" method="post">
		{{ csrf_field() }}
	    <table class="table table-striped table-bordered table-responsive" style="margin-top: 30px;">
			<thead>
				<tr>
				<th>Image ID</th>
				<th>Product ID</th>
				<th>Image</th>
				<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($product_images as $image)    
				<tr>
					<td>{{ $image->id }}</td>
					<td>{{ $image->product_id }}</td>
					<td><img src="{{ asset('storage/product_images/small/' . $image->image) }}" alt="" style="max-height: 150px;"></td>
					<td>
						<a rel="{{ $image->id }}" rel1="delete-product-image" href="javascript:void(0);" class="btn btn-danger deleteRecord">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>

</div>

<div style="display: none;" id="to_copy">
			<div class="row" style="margin-bottom: 10px;">
				<div class="form-group">
	            	<label for="images[]">Image</label>
		            <input class="form-control-file" type="file" class=""  name="images[]" id="image" multiple required>
		        </div>
		        	<a href="#" class="col-sm-2 btn btn-danger remove_button">Remove Image</a>

		        
			</div>
		</div>

<script>
	$(document).ready(function(){
	    var maxField = 10; //Input fields increment limitation
	    var addButton = $('.add_button'); //Add button selector
	    var wrapper = $('.field_wrapper'); //Input field wrapper
	    // var fieldHTML = '<div><input type="text" name="field_name[]" value=""/><a href="javascript:void(0);" class="remove_button">Remove Attribute</a></div>'; //New input field html 
	    var fieldHTML = $('#to_copy').html();
	    var x = 1; //Initial field counter is 1
	    
	    //Once add button is clicked
	    $(addButton).click(function(){
	        //Check maximum number of input fields
	        if(x < maxField){ 
	            x++; //Increment field counter
	            $(wrapper).append(fieldHTML); //Add field html
	        }
	    });
	    
	    //Once remove button is clicked
	    $(wrapper).on('click', '.remove_button', function(e){
	        e.preventDefault();
	        $(this).parent('div').remove(); //Remove field html
	        x--; //Decrement field counter
	    });

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
	});
</script>
@endsection