@extends('layouts.admin')

@section('body')


<div class="table-responsive">

    <form action="/admin/edit-coupon/{{$coupon->id}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
            <label for="coupon_code">Coupon Code</label>
            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Coupon Code" required minLength="5" maxLength="15" value="{{ $coupon->coupon_code }}" >
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" required min="0" autocomplete="off" value="{{ $coupon->amount }}" >
        </div>
        <div class="form-group">
            <label for="amount_type">Amount Type</label>
            <select name="amount_type" class="form-control" id="amount_type">
            	<option value="Percentage" @if($coupon->amount_type == "Percentage") selected @endif >Percentage</option>
            	<option value="Fixed" @if($coupon->amount_type == "Fixed") selected @endif >Fixed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="expiry_date">Expiry Date</label>
            <input type="text" class="form-control" name="expiry_date" id="expiry_date" placeholder="Expiry Date" required autocomplete="off"  value="{{ $coupon->expiry_date }}" >
        </div>
        <div class="form-group">
            <label for="status">Enable</label>
            <input type="checkbox" class="form-check form-check-inline" name="status" id="status" value="1" @if($coupon->status == 1) checked @endif >
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
@endsection