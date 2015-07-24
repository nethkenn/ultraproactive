@extends('admin.layout')
@section('content')
<div class="dashboard">
	<div class="panel-header row">
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-users"></i>
				<span>12</span>
				<div class="panel-label">MEMBERS</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-user"></i>
				<span>259</span>
				<div class="panel-label">SLOTS</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-cloud"></i>
				<span>259</span>
				<div class="panel-label">CODE</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel-box">
				<i class="fa fa-money"></i>
				<span>$320,000</span>
				<div class="panel-label">TOTAL SALES</div>
			</div>
		</div>
	</div>
	<div class="graph">
		<section id="auth-button"></section>
		<section id="timeline"></section>
	</div>
</div>
@endsection
@section('script')

@endsection