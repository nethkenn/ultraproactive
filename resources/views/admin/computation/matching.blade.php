@extends('admin.layout')
@section('content')
<div class="row">
	<div class="header">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="title col-md-8">
			<h2><i class="fa fa-star-half-o"></i> MENTOR BONUS PERCENTAGE PER MEMBERSHIP</h2>
		</div>
	</div>
</div>
<div class="col-md-12">
	<table id="product-table" class="table table-bordered">
		<thead>
			<tr>
				<th class="option-col">ID</th>
				<th>MEMBERSHIP</th>
				<th>NUMBER OF LEVELS</th>
				<th class="option-col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($_membership as $membership)
			<tr>
				<td>{{ $membership->membership_id }}</td>
				<td>{{ $membership->membership_name }}</td>
				<td>{{ $membership->membership_mentor_level}} </td>
				<td><a href="admin/utilities/matching/edit?id={{ $membership->membership_id }}">EDIT</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>


<div class="remodal create-slot" data-remodal-id="process" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="header">
        Encash All Wallet
    </div>
    <form class="form-horizontal" method="POST">

    <input type="hidden" class="token" name="_token" value="{{ csrf_token() }}">

    <button class="button" type="button" data-remodal-action="cancel">Cancel</button>
    <button class="c_slot button"  type="submit" name="encashall">Encash All Wallet</button>
    </form>
</div>
@endsection