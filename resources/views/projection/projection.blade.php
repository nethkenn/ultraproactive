<h3>Perfect Matrix Computation</h3>
<div>PAY-IN PER SLOT ({{ number_format($payin, 2) }})</div>
<div>BINARY - PER PAIR ({{ number_format($per_pair, 2) }})</div>
<div>DIRECT REFERRAL ({{ number_format($direct, 2) }})</div>
<a href="/projection">&laquo; Back</a>
<br>
<br>
<table width="100%" border="1" cellspacing="0" style="text-align: center; font-family: arial; font-size: 14px;">
	<thead>
		<tr>
			<td>Level</td>
			<td>Per Level Slot</td>
			<td># OF SLOTS</td>
			<td>Pay-In</td>
			<td>Binary Payout</td>
			<td>Direct Referral Payout</td>
			<td>First Member Income (Binary)</td>
			<td>Total Payout</td>
			<td>Status</td>
		</tr>
	</thead>
	<tbody>
		@foreach($_projection as $project)
		<tr>
			<td>{{ $project["level"] }}</td>
			<td>{{ number_format($project["slot_count"]) }}</td>
			<td>{{ number_format($project["total_slot_count"]) }}</td>
			<td style="color: green;">{{ "" . number_format($project["total_payin"], 2) }}</td>
			<td style="color: #000;">{{ "" . number_format($project["binary_payout"], 2) }}</td>
			<td style="color: #000;">{{ "" . number_format($project["direct_referral"], 2) }}</td>
			<td style="color: blue;">{{ "" . number_format($project["first_member_income"], 2) }}</td>
			<td style="color: red;">{{ "" . number_format($project["total_payout"], 2) }}</td>
			<td>{!! $project["status"] !!}</td>

		</tr>
		@endforeach
	</tbody>
</table>