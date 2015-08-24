<form method="post">
	@if($errors->all())
		<ul style="color:red;">
			@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	@endif
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<div>
		<label><strong>New Url : </strong></label>
		<label>{{Session::get('new_admin_url') ? Session::get('new_admin_url') : 'No url segment'}}</label>
	</div>
	<div>
		<label><strong>Module Name : </strong></label>
		<input name="module_name" type="text" value="{{Request::old('module_name')}}">
	</div>
	<div>
		<label><strong>Unique Segment : </strong></label>
		<input name="url_segment" type="text" value="{{Request::old('url_segment')}}">
	</div>
	<div>
		<input type="submit" name="submit" value="Save">
	</div>
</form>