@if(session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif

@if(session('danger'))
<div class="alert alert-danger">{{session('danger')}}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif