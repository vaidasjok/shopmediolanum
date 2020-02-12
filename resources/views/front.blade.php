@extends('layouts.index')

@section('center')
Pradinis puslapis

<img style="margin: 0 auto; display: block;" src="{{Storage::disk('local')->url('frontend_images/' . $image_one->image)}}" alt="">
@endsection