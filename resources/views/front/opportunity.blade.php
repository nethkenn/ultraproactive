@extends('front.layout')
@section('content')

<!--<div class="opportunity" style="text-align: center; background-color: #fff; margin: 0 -15px; margin-top: -70px;">-->
<!--	<div class="container row">-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="form-group">-->
<!--				<div class="col-md-8">-->
<!--					sss-->
<!--				</div>-->
<!--				<div class="col-md-4">-->
<!--					@if(count($opportunity) > 0) -->
<!--						@foreach($opportunity as $opp)-->
<!--							<div class="col-md-4">-->
<!--								<iframe style="width:150px;height:70px" src="https://www.youtube.com/embed/{{ $opp->opportunity_link }}" frameborder="0" allowfullscreen=""></iframe>-->
<!--							</div>-->
<!--							<div class="col-md-8">-->
<!--								<strong>{{$opp->opportunity_title}}</strong><br>-->
<!--								<div>-->
<!--									{!! $opp->opportunity_content_2 !!}-->
<!--								</div>-->
<!--							</div>-->
<!--						@endforeach-->
<!--					@endif-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<!--<br>-->
<div class="opportunity" style="text-align: center; background-color: #fff; margin: 0 -15px; margin-top: -70px;">
	<div class="container text-center">
		<div class="opportunity-holder">
			@if(count($opportunity) > 0) 
			<div class="slider slider-nav">
				@foreach($opportunity as $opp)
					<div>
						<a class="cursor-pointer"><h3>{{$opp->opportunity_title}}</h3></a>
						<iframe style="width:250px;height:100px" src="https://www.youtube.com/embed/{{ $opp->opportunity_link }}" frameborder="0" allowfullscreen=""></iframe>
					</div>
				@endforeach
			</div>
			<br>
			<br>
			<br>
			<div class="slider slider-for text-center">
				@foreach($opportunity as $opp)
					<div class="row">
						<div class="col-md-6">
							<iframe style="width:570px;height:300px" src="https://www.youtube.com/embed/{{ $opp->opportunity_link }}" frameborder="0" allowfullscreen=""></iframe>
						</div>
						<div class="col-md-6 text-left">
							<h3>{{$opp->opportunity_title}}</h3>
							<span>
								{!! $opp->opportunity_content !!}
							</span>
						</div>
					</div>
				@endforeach
			</div>
			@else
			<div>
				<h3> NO OPPORTUNITY POSTED </h3>
			</div>
			@endif
		</div>
	</div>
</div>

<!--<div class="opportunity" style="text-align: center; background-color: #fff; margin: 0 -15px; margin-top: -70px;">-->
<!--	<div class="container">-->
<!--		<h3 style="margin-top: 100px; margin-bottom: 100px;">Our compensation plan is designed to reward those people who use and promote UP brand of products</h3>-->
<!--		 <h5 style="margin-bottom: 100px;">Get our products at a cheap price + the chance to earn extra income.</h5> -->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number one">-->
<!--					<div class="content">1</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text">-->
<!--				<div class="name">Retail Profit</div>-->
<!--				<div class="description">30% lifetime product discount</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number two">-->
<!--					<div class="content">2</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text">-->
<!--				<div class="name">Sponsor Bonus</div>-->
<!--				<div class="description">PHP 300.00 for every business pack sold</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number three">-->
<!--					<div class="content">3</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text">-->
<!--				<div class="name">Match Sale Bonus (MSB)</div>-->
<!--				<div class="description">PHP 500.00 for every 150MP on the left & right group.</div>-->
<!--				<div class="tables">-->
<!--					<table>-->
<!--						<tr>-->
<!--							<td>Entry : Entry</td>-->
<!--							 <td>1 Account = 16 MSB/day</td> -->
<!--						</tr>-->
<!--						<tr>-->
<!--							<td>Entry : Product</td>-->
<!--							 <td>3 Account = 20 MSB/day</td> -->
<!--						</tr>-->
<!--						<tr>-->
<!--							<td>Product: Product</td>-->
<!--							 <td>7 Account = 30 MSB/day</td> -->
<!--						</tr>-->
<!--						<tr>-->
<!--							<td>5th MSB converted to GC</td>-->
<!--							 <td></td> -->
<!--						</tr>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number four">-->
<!--					<div class="content">4</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text">-->
<!--				<div class="name">Mentor Bonus</div>-->
<!--				<div class="description">Percentage Income on downline's MSB </br>- 5% of direct sponsor (requirement: 2 direct and bronze rank) </br> - 2% of 2nd generation (requirement: 4 direct and bronze rank)</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number five">-->
<!--					<div class="content">5</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Unilevel Bonus</div>-->
<!--				<div class="description">Percentage income on your total group PV with Dynamic PV Compression</div>-->
<!--				<div class="tables">-->
<!--					<table class="text-center">-->
<!--						<thead style="background-color: e1e1e1;">-->
<!--							<th>Level</th>-->
<!--							<th>Percentage</th>-->
<!--						</thead>-->
<!--						<tbody>-->
<!--							<tr>-->
<!--								<td>1</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>2</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>3</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>4</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>5</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>6</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>7</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>8</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>9</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>10</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number six">-->
<!--					<div class="content">6</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Unilevel Check Match</div>-->
<!--				<div class="description">Percentage income on the unilevel bonus of your direct up to 4th Generation</div>-->
<!--				<div class="tables">-->
<!--					<table>-->
<!--						<thead style="background-color: #e1e1e1;">-->
<!--							<th>Generation</th>-->
<!--							<th>Diamond</th>-->
<!--							<th>Platinum</th>-->
<!--							<th>Star Platinum</th>-->
<!--							<th>Presidential Platinum</th>-->
<!--							<th>Royal Platinum</th>-->
<!--						</thead>-->
<!--						<tbody>-->
<!--							<tr>-->
<!--								<td>1</td>-->
<!--								<td>6%</td>-->
<!--								<td>6%</td>-->
<!--								<td>6%</td>-->
<!--								<td>6%</td>-->
<!--								<td>6%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>2, ,</td>-->
<!--								<td></td>-->
<!--								<td>5%</td>-->
<!--								<td>5%</td>-->
<!--								<td>5%</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>3, , ,</td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td>4%</td>-->
<!--								<td>4%</td>-->
<!--								<td>4%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>4, ,</td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td>3%</td>-->
<!--								<td>3%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>5, , , , ,</td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td></td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number seven">-->
<!--					<div class="content">7</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Leadership Bonus</div>-->
<!--				<div class="description">Percentage income on sales override</div>-->
<!--				<div class="tables">-->
<!--					<table class="text-center">-->
<!--						<thead style="background-color: #e1e1e1;">-->
<!--							<th>Generation</th>-->
<!--							<th>Sales Override</th>-->
<!--						</thead>-->
<!--						<tbody>-->
<!--							<tr>-->
<!--								<td>Diamond</td>-->
<!--								<td>1%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Platinum</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Star Platinum</td>-->
<!--								<td>3%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Presidential Platinum</td>-->
<!--								<td>4%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Royal Platinum</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number eight">-->
<!--					<div class="content">8</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Breakaway Bonus</div>-->
<!--				<div class="description">Percentage income on your downline rank advance for 6 months.</div>-->
<!--				<div class="tables">-->
<!--					<table class="text-center">-->
<!--						<thead style="background-color: #e1e1e1;">-->
<!--							<th>Generation</th>-->
<!--							<th>Sales Override</th>-->
<!--						</thead>-->
<!--						<tbody>-->
<!--							<tr>-->
<!--								<td>Diamond</td>-->
<!--								<td>30%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Platinum</td>-->
<!--								<td>25%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Star Platinum</td>-->
<!--								<td>20%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Presidential Platinum</td>-->
<!--								<td>15%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Royal Platinum</td>-->
<!--								<td>10%</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number nine">-->
<!--					<div class="content">9</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Global Pool Sharing</div>-->
<!--				<div class="description">Global Sharing form the 3% of the global PV Sales</div>-->
<!--				<div class="tables">-->
<!--					<table class="text-center">-->
<!--						<thead style="background-color: #e1e1e1;">-->
<!--							<th>Generation</th>-->
<!--							<th>Sales Override</th>-->
<!--						</thead>-->
<!--						<tbody>-->
<!--							<tr>-->
<!--								<td>Diamond</td>-->
<!--								<td>1%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Platinum</td>-->
<!--								<td>2%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Star Platinum</td>-->
<!--								<td>3%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Presidential Platinum</td>-->
<!--								<td>4%</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Royal Platinum</td>-->
<!--								<td>5%</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="number-holder">-->
<!--				<div class="number ten">-->
<!--					<div class="content">10</div>-->
<!--				</div>-->
<!--			</div>-->
<!--			<div class="text" style="vertical-align: top;">-->
<!--				<div class="name">Travel & Car Bonus</div>-->
<!--				<div class="description">as you help others reach their goals, you will be rewarded continuously!</div>-->
<!--				<img src="/resources/assets/frontend/img/car-bonus.jpg">-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="opportunity-header">Raise your Rank!</div>-->
<!--		<div class="opportunity-holder">-->
<!--			<div class="text">-->
<!--				<div class="tables">-->
<!--					<table style="width: 100%;">-->
<!--						<thead style="background-color: #e1e1e1; height: 30px;">-->
<!--							<th>Rank</th>-->
<!--							<th>Qualification</th>-->
<!--						</thead>-->
<!--						<tbody style="font-size: 16px;">-->
<!--							<tr style="height: 40px;">-->
<!--								<td>Distributor</td>-->
<!--								<td>Signup Entry Package</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Bronze</td>-->
<!--								<td>2 directs + 1 month maintained in unilevel + 5,000 Group PV Sales</td>-->
<!--							</tr>-->

<!--							<tr>-->
<!--								<td>Silver</td>-->
<!--								<td>3 directs + 3 months maintained in unilevel + 10,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Gold</td>-->
<!--								<td>4 directs + 5 months maintained in unilevel + 30,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Diamond</td>-->
<!--								<td>5 directs + 6 months maintained in unilevel + 80,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Platinum</td>-->
<!--								<td>10 directs + 6 months maintained in unilevel + 150,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Star Platinum</td>-->
<!--								<td>3 Platinum in different unilevel legs direct or indirect + 12 months maintained in unilevel + 300,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Presidential Platinum</td>-->
<!--								<td>3 Star Platinum in different unilevel legs direct or indirect + 12 months maintained in unilevel + 600,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--							<tr>-->
<!--								<td>Royal Platinum</td>-->
<!--								<td>3 Presidential Platinum in different unilevel legs + 12 months maintained in unilevel + 1,500,000 Group PV Sales</td>-->
<!--							</tr>-->
<!--						</tbody>-->
<!--					</table>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/opportunity.css">
<link rel="stylesheet" type="text/css" href="/resources/assets/frontend/css/slick.css">
@endsection
@section('script')
<script type="text/javascript" src="/resources/assets/admin/slick.min.js"></script>
<script type="text/javascript" >
;(function($){
	$('.slider-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  fade: true,
	  asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
	  slidesToShow: 3,
	  slidesToScroll: 1,
	  asNavFor: '.slider-for',
	  dots: true,
	  centerMode: true,
	  focusOnSelect: true
	});
})(jQuery);
</script>
@endsection