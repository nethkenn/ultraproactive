@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> TRAVEL REWARD</h2>
		</div>
        <div class="buttons col-md-4 text-right">
            <button onclick="location.href='admin/utilities/travel_reward/add'" type="button" class="btn btn-primary">Add Reward</button>
        </div>
	</div>
	<div class="filters ">
		<div class="col-md-8">
			<a class="{{$active = Request::input('status') ? '' : 'active' }}" href="admin/utilities/travel_reward/">ACTIVE</a>
			<a class="{{$active = Request::input('status') ? 'active' : '' }}" href="admin/utilities/travel_reward?status=archived">ARCHIVED</a>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th class="option-col">ID</th>
				<th>TRAVEL REWARD</th>
				<th>REQUIRED POINTS</th>
				<th class="option-col"></th>
				<th class="option-col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_reward as $reward)
			<tr>
				<td>{{ $reward->travel_reward_id }}</td>
				<td>{{ $reward->travel_reward_name }}</td>
				<td>{{ $reward->required_points }}</td>
				<td><a href="admin/utilities/travel_reward/edit?id={{ $reward->travel_reward_id }}">EDIT</a></td>
				@if(Request::input('status') == 'archived')
				<td><a href="admin/utilities/travel_reward/restore?id={{ $reward->travel_reward_id }}">RESTORE</a></td>
				@else
				<td><a href="admin/utilities/travel_reward/delete?id={{ $reward->travel_reward_id }}">ARCHIVE</a></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

