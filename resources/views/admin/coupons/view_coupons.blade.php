@extends('layouts.admin')

@section('body')

@include('alert')
<h2>View Coupons</h2>
<div class="table-responsive">
    <table id="view_coupons" class="table table-striped table-responsive display">
        <thead>
        <tr>
            <th>Coupon ID</th>
            <th>Coupon Code</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Expiry Date</th>
            <th>Created Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($coupons as $coupon)
        <tr>
			<td>{{ $coupon->id }}</td>
			<td>{{ $coupon->coupon_code }}</td>
			<td>
				{{ $coupon->amount }}
				@if($coupon->amount_type == 'Percentage') % @else € @endif
			</td>
			<td>{{ $coupon->amount_type }}</td>
			<td>{{ $coupon->expiry_date }}</td>
			<td>{{ $coupon->created_at }}</td>
			<td>
				@if($coupon->status == 1) Active @else Inactive @endif
			</td>
			<td class="center">
				<a href="{{ route('editCoupon',['id' => $coupon->id ])}}" class="btn btn-primary">Edit</a>
				<a href="{{route('deleteCoupon', ['id' => $coupon->id])}}" class="btn btn-danger delete-warning">Delete</a>
			</td>	
        </tr>

        @endforeach





        </tbody>
    </table>
    
    

</div>

<script>
	$(document).ready( function () {
	    $('#view_coupons').DataTable({
	    	'paging': true,
	    	'pageLength': 10,
	    	'lengthChange': false,
	    });
	} );
</script>

@endsection