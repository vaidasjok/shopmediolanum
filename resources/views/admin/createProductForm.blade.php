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


    <h2>Create New Product</h2>

    <form action="/admin/sendCreateProductForm" method="post" enctype="multipart/form-data">

        {{csrf_field()}}

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="description" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class=""  name="image" id="image" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <select class="form-control" name="type" id="type" required>
                <option value="">-- Select Type</option>
                @foreach(Config::get('settings.types') as $key => $type)
                <option value="{{ $key }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Category</label>
            <select name="category_id" id="category_id" class="form-control">
                <?php //echo $categories_dropdown; ?>
                
            </select>
        </div>

        <div class="form-group">
            <label for="type">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="price" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

</div>

<script>
    $(document).ready(function() {
        var type = $(this).value = "";
        $('#category_id').hide();
        $('#type').change(function() {
            type = $('#type option:selected').val();
            if(type != "") {
                var _token = $("input[name = '_token']").val();

                $.ajax({
                    method: "GET",
                    url: '/admin/get-categories-for-new-product',
                    data: {_token: _token, type: type},
                    success: function(data, status, XHR) {
                        // alert(data.totalQuantity);
                        if(data.categories_dropdown != '') {
                            $('#category_id').html(data.categories_dropdown);
                        }
                        
                        $('#category_id').show();
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
                
            } else {
                 $('#category_id').hide();
            }
            console.log(type);
        });

    });
</script>
@endsection