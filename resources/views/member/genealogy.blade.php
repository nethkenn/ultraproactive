@extends('member.layout')
@section('content')
<div class="encashment genealogy" style="margin-top: -20px;">
	 <h3>{{ strtoupper(Request::input("mode")) }} GENEALOGY</h3>
	<div class="body para">
		 <iframe src="/member/genealogy/tree?mode={{ Request::input("mode") }}" style="width: 100%; height: 510px; border: 0;"></iframe> 
	</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/genealogy.css">
@endsection