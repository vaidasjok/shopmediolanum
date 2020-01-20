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


    <h2>Add Product Attributes</h2>
     <h3>Product Name: {{ $product->name }} (id: {{ $product->id }})</h3>
    <form action="/admin/add-attributes/{{$product->id}}" method="post" class="">
	<input type="hidden" name="product_id" value="{{ $product->id }}">
        {{csrf_field()}}
		<div class="field_wrapper">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-xs-2">
		            <input type="text" class="form-control" name="sku[]" id="sku" placeholder="SKU" required>	           
		        </div>
		        <div class="col-xs-2">
		            <input type="text" class="form-control" name="size[]" id="size" placeholder="Size (... S, M, L, XL ...)" required>	 
		        </div>
		        <div class="col-xs-2">
		            <input type="text" class="form-control" name="price[]" id="price" placeholder="Price" required>	 
		        </div>
		        <div class="col-xs-2">
		            <input type="text" class="form-control" name="stock[]" id="stock" placeholder="Stock" required>	 
		        </div>
		        <a href="javascript:void(0);" class="col-sm-2 btn add_button">Add Attribute</a>
			</div>
				
		</div>

        <button type="submit" name="submit" style="margin-top: 20px;" class="btn btn-primary">Save Attributes</button>
    </form>
	
   
	<form action="/admin/edit-attributes/{{ $product->id }}" method="post">
		{{ csrf_field() }}
	    <table class="table table-striped table-bordered table-responsive" style="margin-top: 30px;">
			<thead>
				<tr>
				<th>ID</th>
				<th>SKU</th>
				<th>Size</th>
				<th>Price</th>
				<th>Stock</th>
				<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($product->attributes as $attribute)    
				<tr>
					<input type="hidden" name="idAttr[]", value="{{$attribute->id}}">
					<td>{{ $attribute->id }}</td>
					<td>{{ $attribute->sku }}</td>
					<td>{{ $attribute->size }}</td>
					<td><input type="text" name="price[]" value="{{ $attribute->price }}"></td>
					<td><input type="text" name="stock[]" value="{{ $attribute->stock }}"></td>
					<td>
						<input type="submit" value="Update" class="btn btn-primary btn-mini">
						<a rel="{{ $attribute->id }}" rel1="delete-attribute" href="javascript:void(0);" class="btn btn-danger deleteRecord">Delete</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</form>

</div>

<div style="display: none;" id="to_copy">
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-sm-2">
		            <input type="text" class="form-control" name="sku[]" id="sku" placeholder="SKU" required>	           
		        </div>
		        <div class="col-sm-2">
		            <input type="text" class="form-control" name="size[]" id="size" placeholder="Size (... S, M, L, XL ...)" required>	 
		        </div>
		        <div class="col-sm-2">
		            <input type="text" class="form-control" name="price[]" id="price" placeholder="Price" required>	 
		        </div>
		        <div class="col-sm-2">
		            <input type="text" class="form-control" name="stock[]" id="stock" placeholder="Stock" required>	 
		        </div>
		        	<a href="#" class="col-sm-2 btn btn-danger remove_button">Remove Attribute</a>

		        
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