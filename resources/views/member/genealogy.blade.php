@extends('member.layout')
@section('content')
<div class="encashment genealogy">
	<div class="body para">
		 <iframe src="/member/genealogy/tree" style="width: 100%; height: 500px; border: 0;"></iframe> 
	</div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/members/css/genealogy.css">
@endsection