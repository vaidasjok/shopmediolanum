@extends('layouts.index')

@section('center')
<div class="front-wrapper">
	<div class="banner">
		@if(isset($image_one))
		@if($image_one->link !== '') <a href="{{$image_one->link}}"> @endif
			<img style="margin: 0 auto; display: block;" src="{{Storage::disk('local')->url('frontend_images/' . $image_one->image)}}" alt="">
		@if($image_one->link != "") </a> @endif
		@endif
	</div>
	<div class="row-two" style="display: flex; ">
		<div class="two">
			@if(isset($image_two_one))
			@if($image_two_one->link !== '') <a href="{{$image_two_one->link}}"> @endif
			 	<img style="margin: 0 auto; display: block;" src="{{Storage::disk('local')->url('frontend_images/' . $image_two_one->image)}}" alt="">
			@if($image_two_one->link != "") </a> @endif
			@endif
		</div>
		<div class="two second">
			@if(isset($image_two_two))
			@if($image_two_two->link !== '') <a href="{{$image_two_two->link}}"> @endif
				<img style="margin: 0 auto; display: block;" src="{{Storage::disk('local')->url('frontend_images/' . $image_two_two->image)}}" alt="">
			@if($image_two_two->link != "") </a> @endif
			@endif
		</div>
	</div>
	<div class="row-three">
		@if(isset($image_three))
		@if($image_three->link !== '') <a href="{{$image_three->link}}"> @endif
			<img style="margin: 0 auto; display: block;" src="{{Storage::disk('local')->url('frontend_images/' . $image_three->image)}}" alt="">
		@if($image_three->link != "") </a> @endif
		@endif
	</div>

	
</div>
<div class="grey-band">
		<div class="container">
			<div class="row">
				<div class="col-xs-4 lygiuoti">
					<a href="#">How To Shop</a>
				</div>
				<div class="col-xs-4 lygiuoti">
					<a href="#">FAQ's</a>
				</div>
				<div class="col-xs-4 lygiuoti">
					<a href="#">Need Help?</a>
				</div>
			</div>
		</div>
</div>

<div class="container">
	<div class="newsletter text-center">
		<h3>What's New?</h3>
		<p style="margin-top: 24px;">Sign up for exclusive early sale access</p>
		<form style="margin-top: 28px; margin-bottom: 33px;" class="" action="/action_page.php">
			<label for="womenswear"><input type="radio" name="wear" value="womenswear" id="womenswear" >&nbsp;&nbsp;Womenswear</label> &nbsp;&nbsp;&nbsp;&nbsp; <label for="menswear"><input type="radio" name="wear" value="menswear" id="menswear" >&nbsp;&nbsp;Menswear</label>

			<div class="form-inline">
			<input type="email" id="email" placeholder="Yes, here's my email." name="email">
			<button type="submit">Sign up &nbsp;<i class="fa fa-chevron-right"></i></button>
			</div>
		</form>

		<p class="form-info">To opt out, click Unsubscribe at the bottom of our emails. <br>By signing up you agree with our <a href="#">Terms & Conditions</a>, <a href="#">Privacy Policy</a>.</p>
	</div>
</div>


<style>


</style>
@endsection