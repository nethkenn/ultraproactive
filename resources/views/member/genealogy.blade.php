@extends('member.layout')
@section('content')
<div class="encashment genealogy">
	<div class="header">
		<span class="labels">Choose Tree you'd like to see</span>
		<select class="form-control input-sm">
			<option>Binary Genealogy</option>
		</select>
		<span class="pull-right">Number of Downlines: 3</span>
	</div>
	<div class="body para">
		 <iframe src="/admin/maintenance/slots/add" style="width: 100%; height: 395px; border: 0;"></iframe> 
	</div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/genealogy.css">
@endsection