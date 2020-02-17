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


    <h2>Add New Coupon</h2>

    <form action="/admin/add-coupon" method="post" name="add_coupon" id="add_coupon">

        {{csrf_field()}}

        <div class="form-group">
            <label for="coupon_code">Coupon Code</label>
            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code" required minLength="5" maxLength="15" >
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" required min="0" autocomplete="off" >
        </div>
        <div class="form-group">
            <label for="amount_type">Amount Type</label>
            <select name="amount_type" class="form-control" id="amount_type">
            	<option value="Percentage">Percentage</option>
            	<option value="Fixed">Fixed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="text" class="form-control" name="expiry_date" id="expiry_date" placeholder="Expiry Date" required autocomplete="off" >
        </div>
        <div class="form-group">
            <label for="status">Enable</label>
            <input type="checkbox" class="form-check form-check-inline" name="status" id="status" value="1">
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