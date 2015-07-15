@extends('neil.layout')
@section('content')
<form method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="text" name="fn">
	<input type="submit">
</form>
@endsection