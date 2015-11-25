@extends('admin.layout')
@section('content')

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Flushed out</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total Flushed Out</td>
						<td>{{number_format($total_flushed,2)}}</td>
					</tr>	
				</tbody>
			</table>
</div>
<!-- HEADER -->

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Members Summary</h2>
    </div>
</div>
	

<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>PS</td>
						<td>{{number_format($ps,2)}}</td>
					</tr>
					<tr>
						<td>CD</td>
						<td>{{number_format($cd,2)}}</td>
					</tr>
					<tr>
						<td>FS</td>
						<td>{{number_format($fs,2)}}</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>{{number_format($total_slot,2)}}</td>
					</tr>
				</tbody>
			</table>
</div>	

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Members Rebates Summary</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Old Wallet</td>
						<td>{{number_format($old_wallet,2)}}</td>
					</tr>
					<tr>
						<td>Sponsor GC</td>
						<td>{{number_format($sponsor_gc,2)}}</td>
					</tr>
					<tr>
						<td>Match Sales GC</td>
						<td>{{number_format($matching_gc,2)}}</td>
					</tr>
					<tr>
						<td>Unilevel Bonus</td>
						<td>{{number_format($dynamic,2)}}</td>
					</tr>		
					<tr>
						<td>Unilevel Check Match</td>
						<td>{{number_format($checkmatch,2)}}</td>
					</tr>	
					<tr>
						<td>Leadership Bonus</td>
						<td>{{number_format($leadership,2)}}</td>
					</tr>	
					<tr>
						<td>Breakaway Bonus</td>
						<td>{{number_format($breakaway,2)}}</td>
					</tr>	
					<tr>
						<td>Global Pool Sharing</td>
						<td>{{number_format($gps,2)}}</td>
					</tr>				
					<tr>
						<td>Sponsor Bonus</td>
						<td>{{number_format($sponsor,2)}}</td>
					</tr>
					<tr>
						<td>Match Sales Bonus</td>
						<td>{{number_format($matching,2)}}</td>
					</tr>
					<tr>
						<td>Mentors Bonus</td>
						<td>{{number_format($mentor,2)}}</td>
					</tr>
					<tr>
						<td>Total Members Rebates</td>
						<td>{{number_format($total,2)}}</td>
					</tr>
				</tbody>
			</table>
</div>

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Product Sales Summary</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total Order</td>
						<td>{{number_format($total_order,2)}}</td>
					</tr>
					<tr>
						<td>Total Items</td>
						<td>{{number_format($total_items,2)}}</td>
					</tr>
					<tr>
						<td>Total Product Sales</td>
						<td>{{number_format($total_sales,2)}}</td>
					</tr>
				</tbody>
			</table>
</div>

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Member Encashment Summary</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total Encashment Request(s)</td>
						<td>{{number_format($count_encash,2)}}</td>
					</tr>
					<tr>
						<td>Total Encashment</td>
						<td>{{number_format($total_encashment*(-1),2)}}</td>
					</tr>	
				</tbody>
			</table>
</div>


<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Overall</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total Paid Slot Sales</td>
						<td>{{number_format($total_ps_price,2)}}</td>
					</tr>
					<tr>
						<td>Total Product Sales</td>
						<td>{{number_format($total_sales,2)}}</td>
					</tr>	
					<tr>
						<td>Total Company Sales</td>
						<td>{{number_format($company_subtotal,2)}}</td>
					</tr>
					<tr>
						<td>Less Total Member Rebates</td>
						<td>{{number_format($total*(-1),2)}}</td>
					</tr>	
					<tr>
						<td>Total Company Income</td>
						<td>{{number_format($company_total,2)}}</td>
					</tr>
				</tbody>
			</table>
</div>

<div class="header row">
    <div class="title col-md-8">
        <h2><i class="fa fa-table"></i> Membership Codes</h2>
    </div>
</div>
	
<div class="form-container">
			<table id="table" class="table table-bordered">
				<thead>
					<tr class="text-center">
						<th>Name</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Total Unused Codes</td>
						<td>{{number_format($total_avail_codes,2)}}</td>
					</tr>	
					<tr>
						<td>Total Used Codes</td>
						<td>{{number_format($total_used_codes,2)}}</td>
					</tr>
					<tr>
						<td>Total Codes</td>
						<td>{{number_format($total_codes,2)}}</td>
					</tr>
				</tbody>
			</table>
</div>
@endsection

@section('script')

@endsection