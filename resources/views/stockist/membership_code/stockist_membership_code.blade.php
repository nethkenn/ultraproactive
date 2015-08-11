@extends('stockist.layout')
@section('content')
<div class="row">
		<div class="header">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="title col-md-8">
				<h2><i class="fa fa-users"></i> MEMBERSHIP CODES</h2>
			</div>
			<div class="buttons col-md-4 text-right">
				<!--<button type="button" class="btn btn-default" id="check-code-btn"><i class="fa fa-pencil"></i> CHECK CODE</button>-->
				<button onclick="location.href='admin/maintenance/codes/add'" type="button" class="btn btn-primary"><i class="fa fa-plus"></i> GENERATE CODES</button>
			</div>
		</div>

		<div class="filters ">
			<div class="col-md-8">
				<a class="{{$active = Request::input('status') == null ? 'active' : ''}}" href="admin/maintenance/codes/">Company Codes</a>
				<a class="{{$active = Request::input('status') == 'unused' ? 'active' : ''}}" href="admin/maintenance/codes?status=unused">Unused Member Codes</a>
				<a class="{{$active = Request::input('status') == 'used' ? 'active' : ''}}" href="admin/maintenance/codes?status=used">Used Member Codes</a>
				<a class="{{$active = Request::input('status') == 'blocked' ? 'active' : ''}}" href="admin/maintenance/codes?status=blocked">Block</a>
			</div>
		</div>
	<div class="col-md-12">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Pin</th>
						<th>Activation</th>
						<th>Membership</th>
						<th>Code Type</th>
						<th>Product</th>
						<th>Owner</th>
						<th>Voucher</th>
						<th>Date</th>
						<th class="option-col"></th>
						<th class="option-col"></th>
					</tr>
				</thead>
			</table>
	</div>
</div>
@endsection
@section('script')
@endsection